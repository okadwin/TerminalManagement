 $(".datetimepicker").datetimepicker({
 	format:'Y-m-d',
	formatDate:'Y-m-d',
	lang:'ch',
	timepicker:false
 });
 
 $('.datetimepicker').on('keydown', function(){
    if (!(event.keyCode == 8 || event.keyCode == 46)) {
        event.preventDefault();
        return false;
    }
});