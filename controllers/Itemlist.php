<?php
/**
 * Item List Plugin
 *
 * @author Leon M. Saia
 * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Itemlist extends Admin_Controller
{
    private $per_page = 200;

    public function __construct()
    {
        parent::__construct();
        require_login();
        $this->load->model('itemlist_model');
        $this->load->helper('item');
    }

    public function index()
    {
        $page = (int) $this->input->get('page') ?: 1;
        $search = $this->input->get('search');
        $quality = $this->input->get('quality');
        $min_level = $this->input->get('min_level');

        $offset = ($page - 1) * $this->per_page;

        $filters = [
            'search' => $search,
            'quality' => $quality,
            'min_level' => $min_level
        ];

        $data['items'] = $this->itemlist_model->getFilteredItems($filters, $this->per_page, $offset);
        $data['total'] = $this->itemlist_model->getFilteredItemCount($filters);
        $data['filters'] = $filters;
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total'] / $this->per_page);

        $this->template->build('index', $data);
    }
}