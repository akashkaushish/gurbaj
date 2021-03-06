<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');



/**

 * @version $Id$

 * @package solaitra

 * @copyright Copyright (C) 2005 - 2008 Tsiky dia Ampy. All rights reserved.

 * @license GNU/GPL, see LICENSE.php

 */



	class Administration {

		

		function __construct()

		{

			$this->obj =& get_instance();

			$this->obj->load->helper('dashboard');	

			$this->obj->load->helper('text');	

			

			if ( !$this->obj->user->logged_in && $this->obj->uri->segment(2) != 'login' )

			{

				$this->obj->session->set_flashdata('redirect', substr($this->obj->uri->uri_string(), 0));

				redirect('admin/login');

				exit;

			}

			
			if ($this->obj->user->logged_in && count($this->obj->user->level) == 0 )

			{

				$this->obj->session->set_flashdata('notification',"That username is not an admin.");

				$this->obj->user->logout();

				redirect('admin/login');

				exit;

			}			

		}

		



		

		function no_active_users()

		{

			$this->obj->db->where('status', 'active');

			$query = $this->obj->db->get('users');

			

			return $query->num_rows();

		}

		

		function db_size()

		{

			switch ($this->obj->db->dbdriver)

            {

                case 'mysql':

                    $sql = 'SHOW TABLE STATUS';

                    

                    $query = $this->obj->db->query($sql);

                    $result = $query->result_array();

                    

                    foreach ($result as $row)

                    {

                        $db_size = $row['Data_length'] + $row['Index_length'];

                    }

                

                break;

                case 'postgre':

                    $query = $this->obj->db->query("SELECT pg_size_pretty(pg_database_size('" . $this->obj->db->database . "')) as fulldbsize");

                    

                    $row = $query->row();

                    $db_size = $row->fulldbsize;

                break;

                default:

                    $db_size = 0;

                break;

            }

			

			return $db_size;

			

		}

	}





?>