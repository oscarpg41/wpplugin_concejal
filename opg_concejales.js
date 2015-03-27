jQuery(document).ready(function() {

	jQuery('.btnDeleteCouncilor').click(function() {
		var url = "admin.php?page=opg_concejales&task=remove_concejal&id=" + this.id;
	    var r = confirm("Está seguro de eliminar este registro?");
	    if (r == true) {
			window.location = url; 
	    }
	});
});