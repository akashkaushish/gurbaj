<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');



/**

 * @version $Id$

 * @package solaitra

 * @copyright Copyright (C) 2005 - 2008 Tsiky dia Ampy. All rights reserved.

 * @license GNU/GPL, see LICENSE.php

 *

 * @modified: Randall Morgan

 * @email: rmorgan62@gmail.com

 * 

 * @desc: This file has been modified to

 * work with Modular Extension and CI 2.0.0

 * in an effort to update CI-CMS to work under

 * Code Igniter 2.0.0 and PHP 5.1.6 or greater.

 */


	class System {

		var $version ;

		var $revision;

		var $modules;

		var $obj;

        var $theme_dir = 'themes/';

        var $theme		='bitfx';

		var $template	=''; // added

		var $debug ;

		

		function __construct()
		{

			$this->obj =& get_instance();
			if ($this->obj->uri->segment(1) == "install")
			{
				return;
			}

			$this->get_version();

			$this->obj->config->set_item('cache_path', './cache/');
			$dir = $this->obj->config->item('cache_path');
			$this->obj->load->library('cache', array('dir' => $dir));
			$this->get_settings();
			$this->find_modules();
			//$this->load_locales();
			$this->start();

		}

		

		function load_locales()
		{

           $this->obj->load->library('cms_locale');
            // backward comptatibility
            $this->obj->locale = $this->obj->cms_locale;
            //load language for template
			$mofile = APPPATH . 'views/' . $this->theme_dir. $this->theme.'/locale/' . $this->obj->session->userdata('lang') . '.mo' ;
			if ( file_exists($mofile)) 
			{
				$this->obj->cms_locale->load_textdomain($mofile, $this->theme);
			}	
            
			//$this->obj->cms_locale->load_textdomain(APPPATH . 'locale/' . $this->obj->session->userdata('lang') . '.mo');

			$available_langs = $this->obj->cms_locale->codes;
			$lang = $this->obj->session->userdata('lang');
			//if lang is deactivated, get the default and do not load .mo files
			if(!in_array($lang, $available_langs)) $lang = $this->obj->cms_locale->default;
			foreach ($this->modules as $module)
			{
				$mofile = APPPATH . 'modules/'.$module['name'].'/locale/' . $lang . '.mo' ;
				if ( file_exists($mofile)) 
				{
					$this->obj->cms_locale->load_textdomain($mofile, $module['name']);
				}
			}
		}

		function find_modules()
		{

			if ( !$modules = $this->obj->cache->get('modulelist', 'system') )
			{

				$this->obj->db->where('status', 1);
				$this->obj->db->order_by('ordering');
				$query = $this->obj->db->get('modules');
				foreach ($query->result_array() as $row)
				{
					$modules[ $row['name'] ] = $row;
				}
				$this->obj->cache->save('modulelist', $modules, 'system', 0);
			}
	
			$this->modules = $modules;

		}

		function start()
		{
			/*
			if ($this->cache && !$this->obj->user->logged_in && $this->obj->uri->segment(1) != 'admin')
			{
				$this->obj->output->cache($this->cache_time);
			}

			it is better to do the caching in every module. 
			eg. if cache is activated, then all page item should be cached for cache_time
			*/

			//update

		}

		

		function get_settings()
		{

            $base_url = $this->obj->config->item('base_url');
			if(!$settings = $this->obj->cache->get('settings' . $base_url, 'settings'))
			{
                $this->obj->db->where('base_url' ,  $base_url);
                $query = $this->obj->db->get('settings');
                $settings = $query->result();
                $this->obj->cache->save('settings' . $base_url, $settings, 'settings', 0);
			}

			if (!empty($settings))
			{
			   foreach ($settings as $row)
			   {
			      $this->{$row->name} = $row->value;
			   }
			}			
		}

		

		function set($name, $value)
		{

            $base_url = $this->obj->config->item('base_url');
			//update only if changed
			if (!isset($this->$name)) {
				$this->$name = $value;
				$this->obj->db->insert('settings', array('name' => $name, 'value' => $value, 'base_url' => $base_url));
				$this->obj->cache->remove('settings' . $base_url, 'settings');
			}
			elseif ($this->$name != $value) 
			{
				$this->$name = $value;
				$this->obj->db->update('settings', array('value' => $value), "name = '$name' AND base_url = '" . $base_url . "'");
				$this->obj->cache->remove('settings' . $base_url, 'settings');
			}
		}

		function clear_cache()
		{
			$dir = $this->obj->config->item('cache_path');
			$handle = opendir($dir);

			if ($handle)
			{

                while ( false !== ($cache_file = readdir($handle)) )
				{
					// make sure we don't delete silly dirs like .svn, or . or ..
					if ($cache_file != 'index.html' && substr($cache_file, 0, 1) != ".")
					{
						if(is_dir($cache_file) && substr($chache_file, 0, 1) != ".")
						{
							$this->rm($dir.$cache_file);	
						}
						else
						{
							$this->rm($dir.$cache_file);
						}
					}
				}
			}
		}

		function get_version()
		{
			$version = @file_get_contents(APPPATH . "version.txt");
			$this->version = strstr($version, '.');
			$this->revision = stristr($version, '.'); 
		}

		// Allows removing files and directories on 
		// Windows Servers where unlink seems to fail.

		function rm($fileglob)
		{
			if (is_string($fileglob)) 
			{
				if (is_file($fileglob)) 
				{
					return unlink($fileglob);
				} 
				else if (is_dir($fileglob)) 
				{
					$ok = $this->rm("$fileglob/*");
					if (! $ok) 
					{
						return false;
					}
					return @rmdir($fileglob);
				} 
				else 
				{
					$matching = glob($fileglob);
					if ($matching === false) 
					{
						trigger_error(sprintf('No files match supplied glob %s', $fileglob), E_USER_WARNING);
						return false;
					}   
					$callback = array($this, __FUNCTION__);    
					$rcs = array_map($callback, $matching);
					if (in_array(false, $rcs)) 
					{
						return false;
					}
				}       
			} 
			else if (is_array($fileglob)) 
			{

				$callback = array($this, __FUNCTION__);

				$rcs = array_map($callback, $fileglob);

				if (in_array(false, $rcs)) 

				{

					return false;

				}

			} 

			else 

			{

				trigger_error('Param #1 must be filename or glob pattern, or array of filenames or glob patterns', E_USER_ERROR);

				return false;

			}

		

			return true;

		}

	}





?>