<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter File Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/helpers/file_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('check_dir'))
{	
	function check_dir($dirName,$return='array',$htaccess=true)
	{
		if(is_array($dirName))
		{
			$dirName	= $dirName['server_path'];
		}

		if(is_file($dirName))
		{
			return false;
		}

		if (!is_dir($dirName)) 
		{
		    mkdir($dirName, 0777, TRUE);
		    write_file($dirName.'index.html', '');
		    if($htaccess)
		    {
		    	write_file($dirName.'.htaccess', '<IfModule authz_core_module>
	Require all denied
</IfModule>
<IfModule !authz_core_module>
	Deny from all
</IfModule>');
		    }
		}
		return (($return == 'array') ? get_dir_file_info($dirName) : (($return == 'combine') ? array('isdir'=>true,'content'=>get_dir_file_info($dirName)) : true));
	}
}

if ( ! function_exists('check_file'))
{	
	function check_file($filemeta=array(),$createFile=false,$fileData=NULL)
	{
		if(is_array($filemeta) && (is_file($filemeta['server_path']) || is_file($filemeta['server_path'].DIRECTORY_SEPARATOR.$filemeta['name']) || is_file($filemeta['server_path'].$filemeta['name'])) && $filemeta['name'] <> 'index.html' && $filemeta['name'] <> '.htaccess')
		{
			if($createFile == true)
			{
		    	write_file($filemeta['server_path'].$filemeta['name'], $fileData);
				return true;
			}
			else
			{
				return true;
			}
		}
		else
		{
			if($createFile == true)
			{
		    	write_file($filemeta['server_path'].$filemeta['name'], $fileData);
				return true;
			}
			else
			{
				return false;
			}
		}
	}
}


if ( ! function_exists('rename_dir'))
{	
	function rename_dir($oldDirName,$newDirName)
	{
		if (!rename($oldDirName,$newDirName))
		{
			if (copy ($oldDirName,$newDirName))
			{
				chmod($newDirName,0777);
				unlink($oldDirName);
				return TRUE;
			}
			return FALSE;
		}
	}
}

if ( ! function_exists('recursiveRemoveDirectory'))
{	
	function recursiveRemoveDirectory($directory)
	{
	    foreach(glob("{$directory}/*") as $file)
	    {
	        if(is_dir($file))
	        { 
	            recursiveRemoveDirectory($file);
	        }
	        else
	        {
	            unlink($file);
	        }
	    }
	    
        if(is_dir($directory))
        { 
		    rmdir($directory);
	    }
	}
}
if ( ! function_exists('file_scanner'))
{	
	function file_scanner($path,$noindex=true,$timemodified=false,$timekey='changed',$timeformat='timestamp')
	{
		if(is_dir($path))
		{
			$files = get_filenames($path,true);

			$arrFile = array();
			$i = 0;
			foreach ($files as $idxF => $file)
			{
				if($noindex == false || ($noindex == true && basename($file) <> 'index.html'))
				{
					$arrFile[$i]	= file_detail($file,$timemodified,$timekey,$timeformat);
					$i++;
				}
			}

			return $arrFile;
		}

		return FALSE;
	}
}

if ( ! function_exists('file_detail'))
{	
	function file_detail($pathfilename,$timemodified=false,$timekey='changed',$timeformat='timestamp')
	{
		if(is_file($pathfilename))
		{
			$path_parts = pathinfo($pathfilename);

			$file['file_name']		= $path_parts['basename'];
			$file['raw_name']		= $path_parts['filename'];
			$file['orig_name']		= $path_parts['basename'];
			$file['client_name']	= $path_parts['basename'];
			$file['file_path']		= $path_parts['dirname'].DIRECTORY_SEPARATOR;
			$file['full_path']		= $pathfilename;
			$file['file_size']		= round(filesize($pathfilename)/1024, 2);
			$file['file_ext']		= '.'.$path_parts['extension'];
			$file['image_width']	= NULL;
			$file['image_height']	= NULL;
			$file['image_type']		= NULL;
			$file['image_size_str']	= NULL;

			if($timemodified)
			{
				$file[$timekey]		= ($timeformat == 'timestamp') ? get_file_info($pathfilename)['date'] : gmdate("Y-m-d H:i:s", get_file_info($pathfilename)['date']);
			}

			$filetype 	= mime_content_type($pathfilename);
			$png_mimes  = array('image/x-png');
			$jpeg_mimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');

			if (in_array($filetype, $png_mimes))
			{
				$filetype = 'image/png';
			}
			elseif (in_array($filetype, $jpeg_mimes))
			{
				$filetype = 'image/jpeg';
			}

			$img_mimes = array('image/gif',	'image/jpeg', 'image/png');

			$file['file_type']	= $filetype;
			$file['is_image']	= in_array($filetype, $img_mimes, TRUE);

			if ($file['is_image'])
			{
				$D = @getimagesize($pathfilename);

				$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');

				$file['image_width']	= $D[0];
				$file['image_height']	= $D[1];
				$file['image_type']		= isset($types[$D[2]]) ? $types[$D[2]] : 'unknown';
				$file['image_size_str']	= $D[3];
			}

			return $file;
		}

		return FALSE;
	}
}
