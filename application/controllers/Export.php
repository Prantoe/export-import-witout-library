<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Export extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Barang_model');
    }


    public function index()
    {
        $data['title'] = 'Export';
        $data['semuabarang'] = $this->Barang_model->getDataBarang();
        $this->load->view('export_view', $data);
    }

    public function uploaddata()
    {
        $config['upload_path'] = './UPLOAD/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['file_name'] = 'doc' . time();
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('importexcel')) {
            $file = $this->upload->data();
            $reader = ReaderEntityFactory::createXLSXReader();

            $reader->open('./UPLOAD/' . $file['file_name']);

            foreach ($reader->getSheetIterator() as $sheet) {
                $numRow = 1;
                foreach ($sheet->getRowIterator() as $row) {
                    if ($numRow > 1) {
                        $databarang = array(
                            'kode_barang' => $row->getCellAtIndex(1),
                            'nama_barang' => $row->getCellAtIndex(2),
                            'jumlah' => $row->getCellAtIndex(3),
                            'date_created' => time(),
                            'date_modified' => time(),
                        );
                        $this->Barang_model->import_data($databarang);
                    }
                    $numRow++;
                }
                $reader->close();
                unlink('UPLOAD/' . $file['file_name']);
                $this->session->set_flashdata('pesan', 'inmport success');
                redirect('export');
            }
        } else {
            echo "error!!" . $this->upload->display_errors();
        }
    }

    public function excel()
    {
        $data['title'] = 'laporan excel';
        $data['semuabarang'] = $this->Barang_model->getDataBarang();
        $this->load->view('excel/excel', $data);
    }
}
