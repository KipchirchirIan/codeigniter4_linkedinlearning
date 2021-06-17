<?php


namespace App\Controllers;


use App\Models\Property;
use CodeIgniter\CodeIgniter;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Validation;
use Faker\Factory;
use PhpParser\Node\Expr\Cast\Object_;

class Properties extends BaseController
{
    /**
     * @var \CodeIgniter\Session\Session
     */
    private $session;

    public function __construct()
    {
        $this->propertyModel = model(Property::class);
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        log_message('debug', 'My First Log');

        $faker = Factory::create();

        $data = [
            'user_name' => $faker->name,
            'status_groups' => ['All', 'Available', 'Unavailable'],
            'properties' => $this->propertyModel->getAll(),
            'selected_filter' => $this->session->get('selected_filter'),
        ];

        echo view('layouts/header');
        echo view('layouts/foundation_nav');
        echo view('properties/index', $data);
        echo view('layouts/footer');
    }

    public function kml_export()
    {
//        $this->response->setContentType('application/xml');
        $this->response->setContentType('application/octet-stream');
        $this->response->setHeader('Content-Disposition', 'inline;filename="real_estate_kml_export.kml"');
        return view('properties/kml_export');
    }

    public function set_filter()
    {
//        $session = session();
        $session_data['selected_filter'] = $this->request->getGet('filter');
        $this->session->set($session_data);

        return redirect()->to('/properties');
    }

    public function show($id)
    {
        $version = $this->propertyModel->get_version();
        $data = [
            'id' => $id,
            'name' => $this->propertyModel->getPropertyName(),
            'version' => $version->connID->server_info,
        ];

        echo view('properties/show', $data);
    }

    public function db_test()
    {
        $propertyModel = model(Property::class);
        $propertyModel->connection_test();
    }

    /**
     * @param $id
     * @return RedirectResponse|void
     */
    public function edit($id)
    {
        helper('form');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->request->getPost('name');
            $description = $this->request->getPost('description');
            $image = false;

            log_message('debug', 'Form data: ' . print_r($_POST, true));

            $validated = $this->validate([
                'name' => ['label' => 'Name', 'rules' => 'required'],
                'description' => ['label' => 'Description', 'rules' => 'required'],
            ]);


            if ($_FILES['image_file']) {
                $image = $this->doUpload();
            }

            $new_data = [
                'name' => $name,
                'description' => $description
            ];

            if ($image) {
                $new_data['image'] = $image;
            }

            if ($validated) {
                $this->propertyModel->updateSingle($id, $new_data);
                return redirect()->to('/properties');
            } else {

                $data = [
                    'property' => [
                        'name' => $this->request->getPost('name'),
                        'description' => $this->request->getPost('description'),
                    ],
                    'validation' => $this->validator,
                ];

                echo view('layouts/header');
                echo view('layouts/foundation_nav');
                echo view('properties/edit', $data);
                echo view('layouts/footer');
            }
        }

        $data = [
            'property' => $this->propertyModel->getSingle($id),
        ];

        echo view('layouts/header');
        echo view('layouts/foundation_nav');
        echo view('properties/edit', $data);
        echo view('layouts/footer');
    }

    public function doUpload()
    {
        $file = $this->request->getFile('image_file');

        if (! $file) {
            throw new \Exception('File does not exist');
        }

        if ($file->isValid() && ! $file->hasMoved()) {
            $file->move('./assets/images/');
            return $file->getName();
        }

        //throw new \RuntimeException($file->getErrorString(). '(' . $file->getError() . ')');
    }

}