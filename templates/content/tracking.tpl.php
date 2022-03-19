<form method="post" id="geocoding_form">
<!-- Google Map -->
<input type="text" name="referenceId" id="referenceId"/>
<input type="submit" class="btn" value="Search" />
<div class="modal hide fade small_rates" id="mapeff"  data-keyboard="false" data-backdrop="static">
	<div class="modal-header">
    	<div class="row-fluid">
    	<div class="span6">
			<div class="headline margin-0">
			<h3>Status:&nbsp;<span id="status" class="my_yellow"></span></h3>
            </div>
       	</div>
        <div class="span6">
        	<div class="headline margin-0" id="sign" style="display:none;">
			<h3>Signed by:&nbsp;<span id="remark" class="my_green"></span></h3>
            </div>
       	</div>
        </div>
	</div>
	<div class="modal-body">
		<div id="map1">
		</div>
		<table class="table" id="tblDesktop">
			
		</table>
		<table class="table" id="tblMobile">
			
		</table>
        
	</div>    
	<div class="modal-footer">
    <a href="#" class="btn-u btn-u-primary" data-dismiss="modal" id="closemodal">Close</a>
    </div>
</div>
</form>

