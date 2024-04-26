<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\TarjetasTable;
use Cake\Http\Response;

/**
 * Tarjetas Controller
 *
 * @property \App\Model\Table\TarjetasTable $Tarjetas
 */
class TarjetasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Tarjetas->find();
        $tarjetas = $this->paginate($query);

        $this->set(compact('tarjetas'));
    }

    /**
     * View method
     *
     * @param string|null $id Tarjeta id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tarjeta = $this->Tarjetas->get($id, contain: []);
        $this->set(compact('tarjeta'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tarjeta = $this->Tarjetas->newEmptyEntity();
        if ($this->request->is('post')) {
            $tarjeta = $this->Tarjetas->patchEntity($tarjeta, $this->request->getData());
            if ($this->Tarjetas->save($tarjeta)) {
                $this->Flash->success(__('The tarjeta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tarjeta could not be saved. Please, try again.'));
        }
        $this->set(compact('tarjeta'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tarjeta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tarjeta = $this->Tarjetas->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tarjeta = $this->Tarjetas->patchEntity($tarjeta, $this->request->getData());
            if ($this->Tarjetas->save($tarjeta)) {
                $this->Flash->success(__('The tarjeta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tarjeta could not be saved. Please, try again.'));
        }
        $this->set(compact('tarjeta'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tarjeta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tarjeta = $this->Tarjetas->get($id);
        if ($this->Tarjetas->delete($tarjeta)) {
            $this->Flash->success(__('The tarjeta has been deleted.'));
        } else {
            $this->Flash->error(__('The tarjeta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // En el controlador TarjetasController
// En el controlador TarjetasController
// En el controlador TarjetasController
public function crearTarjeta()
{
    //dd("Hola");
    // Verifica si se recibió un nombre de tarjeta en la solicitud
    $nombreTarjeta = $this->request->getQuery('nombre');

    if ($nombreTarjeta) {
        // Crea una instancia de la tabla de tarjetas
        $tarjetasTable = $this->getTableLocator()->get('Tarjetas');

        // Datos de ejemplo para la nueva tarjeta
        $nuevaTarjeta = [
            'nombre' => $nombreTarjeta,
            'fecha_creacion' => date('Y-m-d H:i:s'), // Fecha y hora actual
            'estado' => 'Pendiente', // Estado inicial
        ];

        // Crea la nueva tarjeta en la base de datos
        $tarjeta = $tarjetasTable->newEntity($nuevaTarjeta);
        if ($tarjetasTable->save($tarjeta)) {
            // Tarjeta creada exitosamente
            $mensaje = __('La tarjeta "{0}" ha sido creada correctamente.', $nombreTarjeta);
        } else {
            // Error al crear la tarjeta
            $mensaje = __('No se pudo crear la tarjeta "{0}". Por favor, intenta de nuevo.', $nombreTarjeta);
        }
    } else {
        // No se proporcionó un nombre de tarjeta
        $mensaje = 'Debe proporcionar un nombre de tarjeta.';
    }

    // Responde con el mensaje
    $this->set(compact('mensaje'));
    $this->viewBuilder()->setOption('serialize', ['mensaje']);
}
    
}
