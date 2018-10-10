<?php
namespace App\Lib;
/**
 * 
 * This Library use for helper.
 * 
 **/

class Helper
{
    
    public static function getStatus($current_status,$id){
		 $html = '';
			  switch ($current_status) {
				  case '1':
					   $html =  '<span class="f-left margin-r-5" id = "status_'.$id.'"><a data-toggle="tooltip"  class="btn btn-success btn-xs" title="Active" onClick="changeStatus('.$id.')" >Active</a></span>';
					  break;
					  case '0':
					   $html =  '<span class="f-left margin-r-5" id = "status_'.$id.'"><a data-toggle="tooltip"  class="btn btn-danger btn-xs" title="Inactive" onClick="changeStatus('.$id.')" >Inactive</a></span>';
					  break;
					  case '2':
					   $html =  '<span class="f-left margin-r-5" id = "status_'.$id.'"><a data-toggle="tooltip"  class="btn btn-danger btn-xs" title="Inactive" onClick="changeStatus('.$id.')" >Inactive</a></span>';
					  break;
				  
				  default:
					
					  break;
			  }
		  return $html;
    }
    
    public static function getButtons($array = [],$id=NULL) {
		
    $btn = [
            "Edit" => "<span class='f-left margin-r-5' style='padding-left:5px;'><a data-toggle='tooltip'  class='btn btn-primary btn-xs' title='Edit' href='LINK'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a></span>",
            "Active" => '<span class="f-left margin-r-5"> <a data-toggle="tooltip" class="btn btn-success btn-xs" title="Active" href="LINK"><i class="fa fa-check" aria-hidden="true"></i></a></span>',
            "Inactive" => '<span class="f-left margin-r-5"> <a data-toggle="tooltip" class="btn btn-warning btn-xs" title="Inactive" href="LINK"><i class="fa fa-times" aria-hidden="true"></i></a></span>',
            "Delete" => '<form method="POST" action="LINK" accept-charset="UTF-8" style="display:inline" class="deleteFrom"><input name="_method" value="POST" type="hidden">
' . csrf_field() . '<span><a href="javascript:void(0)" onclick="confirm_click(this);" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span></form>',
            "View" => '<span class="f-left margin-r-5"><a data-toggle="tooltip"  class="btn btn-info btn-xs" title="View" href="LINK"><i class="fa fa-eye" aria-hidden="true"></i></a></span>',
            "Work" => '<span class="f-left margin-r-5"><button type="button" class="btn btn-primary" onclick="noOfWorkers('.$id.')" data-toggle="modal" data-id="ID" >LINK</button></span>'
        ];		
        $html = '';
        foreach($array as $arr)
        {
        	if($arr['link']=="Work"){
        		$html  .= str_replace("LINK",$arr['link'],$btn[$arr['key']]);
        		$html  .= str_replace("ID",$arr['link'],$btn[$arr['key']]);
        	}else{
        		$html  .= str_replace("LINK",$arr['link'],$btn[$arr['key']]);	
        	}
        }
        return $html;
    }    
    
    
    public static function displayImage($url) {
        $html = '';
        if(!empty($url)){
            $html .= "<img src=".url($url)." style='width:45px;height: 45px;' />";          
        }
        return $html;
    }    
    
}
