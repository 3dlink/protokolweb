<?php

defined('ABSPATH') || die('Access Denied');

$search_data = $this->search_data;
$filters_data = $this->filters_data;
$arrangement_data = $this->arrangement_data;
$sort_data = $this->sort_data;
$pagination = $this->pagination;

echo WDFHTML::wde_filters_inputs($this->data);
