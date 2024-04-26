<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Response;
use Cake\Http\Exception\InternalErrorException;

/**
 * Test Controller
 *
 */
class TestController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Test->find();
        $test = $this->paginate($query);

        $this->set(compact('test'));
    }

    /**
     * View method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $test = $this->Test->get($id, contain: []);
        $this->set(compact('test'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $test = $this->Test->newEmptyEntity();
        if ($this->request->is('post')) {
            $test = $this->Test->patchEntity($test, $this->request->getData());
            if ($this->Test->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }
        $this->set(compact('test'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $test = $this->Test->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $test = $this->Test->patchEntity($test, $this->request->getData());
            if ($this->Test->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }
        $this->set(compact('test'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $test = $this->Test->get($id);
        if ($this->Test->delete($test)) {
            $this->Flash->success(__('The test has been deleted.'));
        } else {
            $this->Flash->error(__('The test could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function saludo()
{
    $saludos = [
        "¡Hola, amigo!",
        "¡Saludos desde CakePHP!",
        "¡Bienvenido a mi aplicación!",
        "¡Hola, mundo! ¿Cómo estás hoy?",
        "¡Que tengas un día increíble!",
        "¡Qué alegría verte por aquí!",
        "¡Hola! ¿En qué puedo ayudarte?",
        "¡Hola! Espero que tu día esté lleno de sonrisas.",
        "¡Hola, hola! ¿Listo para explorar?",
        "¡Hola, extraño! ¡Te deseo lo mejor!",
        "¡Hola, aventurero! ¿Listo para comenzar?",
        "¡Hola, viajero! ¡Qué bueno verte aquí!",
    ];

    // Selecciona un saludo aleatorio de la lista
    $saludo = $saludos[array_rand($saludos)];

    // Devuelve el saludo
    return $this->response->withStringBody($saludo);
}

public function escribirSaludo()
{
    $horaActual = date('H:i:s');
    // Contenido del saludo
    $saludo = "Hola desde CakePHP! a las: $horaActual\n";

    // Ruta del archivo en el directorio webroot
    $rutaArchivo = WWW_ROOT . 'saludo.txt';

    // Intenta escribir el saludo en el archivo
    if (file_put_contents($rutaArchivo, $saludo, FILE_APPEND) === false) {
        // Si no se pudo escribir el archivo, lanzamos una excepción
        throw new InternalErrorException("No se pudo escribir el archivo de saludo.");
    }

    // Creamos una respuesta con un mensaje indicando que se escribió el archivo
    $response = new Response();
    $response = $response->withStringBody('El saludo se escribió correctamente en el archivo.');

    // Devolvemos la respuesta
    return $response;
}

}
