function borrarConcejal(id){
	var url = "admin.php?page=opg_concejales&task=remove_concejal&id=" + id;
    var r = confirm("Está seguro de eliminar este registro?");
    if (r == true) {
		window.location = url; 
    }
}