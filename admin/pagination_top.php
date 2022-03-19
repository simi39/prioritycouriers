<?php

global $page_rows;
$page_rows = 10;
function pagination($result=null,$pagenum=null,$display_link=false,$all=null)
{

	if (!(isset($pagenum)))
	{
		$pagenum = 1;
	}

	$max = '';

	if (is_array($result) && count($result) > 0) {
		$result = count($result);
	}else{
		$result = 0;
	}
	$rows =($all!='')?($all):($result);
	$page_rows = 10;
	$last = ceil($rows/$page_rows);

	if ($pagenum < 1)  {
		$pagenum = 1;
	}
	elseif ($pagenum > $last)
	{
		$pagenum = $last;
	}

	$from =$pagenum*10-10;
	
	if($pagenum==$last){
		$to =$rows;
	}else{
		$to =($pagenum*10);
	}

	if($display_link==true)//for bottom display page number from & to
	{
		if($all!=0)
		{
			echo "<div class='pagination' style='padding-top:30px;'><span style='float:left; padding-bottom:15px;'>Showing from ".($from+1)." to ".($to)." of  ".($rows)." entry</span><span style='float:right; line-height:2;'>";
		}	
		
		unset($_GET["pagenum"]);
		$queryString = '';
		if(!empty($_GET))
		{		
		foreach ($_GET as $key => $value) {
			$queryString .= $key . '=' . $value . '&';
		}
		}
		$baseLink=$_SERVER['SCRIPT_NAME']."?".$queryString."pagenum=";

		if ($pagenum != 1)
		{
			echo " <a href='".$baseLink."1' id='pagination'> First</a> ";
			$previous = $pagenum-1;
			echo " <a href='".$baseLink.$previous."' id='pagination'> Previous</a> ";
		}
		
		//Show only 3 pages before current page(so that we don't have too many pages)
		$min = ($pagenum - 3 < $last && $pagenum-3 > 0) ? $pagenum-3 : 1;
	
		//Show only 3 pages after current page(so that we don't have too many pages)
		$max = ($pagenum + 3 > $last) ? $last : $pagenum+3;
		
		//Variable for the actual page links
		$pageLinks = "";
	
		//Loop to generate the page links
		for($i=$min;$i<=$max;$i++)
		{
			if($pagenum==$i)
			{
				//Current Page
				echo '<span class="pagination_active">'.$i.'</span>';
			}
			else
			{
				echo '<a id="pagination" href="'.$baseLink.$i.'" class="page">'.$i.'</a>';
			}
		}

		if ($pagenum != $last)
		{

			$next = $pagenum+1;

			echo " <a href='".$baseLink.$next."' id='pagination'>Next</a> ";
			echo " <a href='".$baseLink.$last."'id='pagination'>Last</a> ";
		}
		if($all!=0)
		{
			echo "</span></div>";
		}
	}
	else{
		$parameter =array($from,$to);
		return($parameter);
	}
}
?>
