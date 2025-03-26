<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Itemlist_model extends CI_Model
{
    private $world_db;

    public function __construct()
    {
        parent::__construct();
        $this->world_db = $this->load->database('world', TRUE);
    }

    public function getFilteredItems($filters, $limit, $offset)
    {
        $sql = "SELECT entry, name, BuyPrice, RequiredLevel, Quality FROM item_template WHERE 1=1";
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND name LIKE ?";
            $params[] = '%' . $filters['search'] . '%';
        }

        if (is_numeric($filters['quality'])) {
            $sql .= " AND Quality = ?";
            $params[] = $filters['quality'];
        }

        if (is_numeric($filters['min_level'])) {
            $sql .= " AND RequiredLevel >= ?";
            $params[] = $filters['min_level'];
        }

        $sql .= " ORDER BY RequiredLevel DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        return $this->world_db->query($sql, $params)->result();
    }

    public function getFilteredItemCount($filters)
    {
        $sql = "SELECT COUNT(*) as total FROM item_template WHERE 1=1";
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND name LIKE ?";
            $params[] = '%' . $filters['search'] . '%';
        }

        if (is_numeric($filters['quality'])) {
            $sql .= " AND Quality = ?";
            $params[] = $filters['quality'];
        }

        if (is_numeric($filters['min_level'])) {
            $sql .= " AND RequiredLevel >= ?";
            $params[] = $filters['min_level'];
        }

        $query = $this->world_db->query($sql, $params);
        return $query->row()->total ?? 0;
    }
}