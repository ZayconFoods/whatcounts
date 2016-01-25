<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 1/22/16
 * Time: 4:15 PM
 */

namespace ZayconWhatCounts;

class Folder {

	const FOLDER_TYPE_SEGMENTATION = 1;
	const FOLDER_TYPE_TEMPLATE = 2;
	const FOLDER_TYPE_LIST = 3;
	const FOLDER_TYPE_ARTICLE = 4;

	private $folder_types = array(1, 2, 3, 4);
	private $folder_id;
	private $folder_path;
	private $folder_type;

	/**
	 * @return mixed
	 */
	public function getFolderId()
	{
		return $this->folder_id;
	}

	/**
	 * @param mixed $folder_id
	 *
	 * @return Folder
	 */
	public function setFolderId( $folder_id )
	{
		$this->folder_id = (is_numeric($folder_id)) ? abs(round($folder_id)) : NULL;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFolderPath()
	{
		return $this->folder_path;
	}

	/**
	 * @param mixed $folder_path
	 *
	 * @return Folder
	 */
	public function setFolderPath( $folder_path )
	{
		$this->folder_path = $folder_path;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFolderType()
	{
		return $this->folder_type;
	}

	/**
	 * @param mixed $folder_type
	 *
	 * @return Folder
	 */
	public function setFolderType( $folder_type )
	{
		$this->folder_type = (in_array($folder_type, $this->folder_types)) ? $folder_type : NULL;

		return $this;
	}
}