<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Exception\MethodNotAllowedException;

/**
 * KanbanFlow Controller
 *
 */
class KanbanFlowController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        // Desactivar CSRF solo para la acción kanbanAction
        if ($this->getRequest()->getParam('action') === 'kanbanAction') {
            $this->getEventManager()->off($this->Csrf);
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->KanbanFlow->find();
        $kanbanFlow = $this->paginate($query);

        $this->set(compact('kanbanFlow'));
    }

    /**
     * View method
     *
     * @param string|null $id Kanban Flow id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kanbanFlow = $this->KanbanFlow->get($id, contain: []);
        $this->set(compact('kanbanFlow'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kanbanFlow = $this->KanbanFlow->newEmptyEntity();
        if ($this->request->is('post')) {
            $kanbanFlow = $this->KanbanFlow->patchEntity($kanbanFlow, $this->request->getData());
            if ($this->KanbanFlow->save($kanbanFlow)) {
                $this->Flash->success(__('The kanban flow has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kanban flow could not be saved. Please, try again.'));
        }
        $this->set(compact('kanbanFlow'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Kanban Flow id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kanbanFlow = $this->KanbanFlow->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kanbanFlow = $this->KanbanFlow->patchEntity($kanbanFlow, $this->request->getData());
            if ($this->KanbanFlow->save($kanbanFlow)) {
                $this->Flash->success(__('The kanban flow has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kanban flow could not be saved. Please, try again.'));
        }
        $this->set(compact('kanbanFlow'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Kanban Flow id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kanbanFlow = $this->KanbanFlow->get($id);
        if ($this->KanbanFlow->delete($kanbanFlow)) {
            $this->Flash->success(__('The kanban flow has been deleted.'));
        } else {
            $this->Flash->error(__('The kanban flow could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function kanbanAction()
    {
        // Verificar que la petición sea POST
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('This action only allows POST requests');
        }
        // Verificar la firma del webhook
        if ($this->verifyKanbanFlowWebhookRequest()) {
            // Obtener el cuerpo de la solicitud
            $jsonData = file_get_contents('php://input');
            
            // Obtener la firma proporcionada en el encabezado
            $signature = $this->getRequest()->getHeaderLine('x-kanbanflow-signature');
            
            // Obtener la clave secreta
            $secretKey = Configure::read('KanbanFlow.webhook_key');
            
            // Calcular el HMAC-SHA256 del cuerpo de la solicitud
            $computedSignature = hash_hmac('sha256', $jsonData, $secretKey);
            
            // Comparar las firmas
            if (hash_equals('sha256=' . $computedSignature, $signature)) {
                // Escribir el resultado en un archivo
                $filePath = WWW_ROOT . 'webhook.txt'; // Ruta al archivo webhook.txt en el directorio webroot
                file_put_contents($filePath, $computedSignature);
                
                return true; // Opcional: Devolver true para indicar que la operación fue exitosa
            } else {
                throw new UnauthorizedException('Invalid signature');
            }
        } else {
            throw new UnauthorizedException('Invalid signature');
        }
    }
    
    public function verifyKanbanFlowWebhookRequest(): bool
    {
        // Obtiene el cuerpo de la solicitud
        $jsonData = file_get_contents('php://input');
        
        
        // Obtiene la firma proporcionada en el encabezado
        $signature = $this->getRequest()->getHeaderLine('x-kanbanflow-signature');
        
        // Obtiene la clave secreta
        $secretKey = Configure::read('KanbanFlow.webhook_key');
        
        // Calcula el HMAC-SHA256 del cuerpo de la solicitud
        $computedSignature = hash_hmac('sha256', $jsonData, $secretKey);
        
        // Compara las firmas
        if (hash_equals('sha256=' . $computedSignature, $signature)) {
            return true;
        } else {
            throw new UnauthorizedException('Invalid signature');
        }
    }

}
