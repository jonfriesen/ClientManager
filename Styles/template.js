 var GB_ANIMATION = true;
 $(document).ready(function(){
   $("a.greybox").click(function(){
     var t = this.title || this.innerHTML || this.href;
     GB_show(t,this.href,470,600);
     return false;
  });
   $(".datepicker").datePicker();
   
   $(".ta-clear").focus(function(){
	   if($(this).get(0).cleared)
		   return;
	   $(this).val('');
	   $(this).css('text-align', 'left');
	   $(this).get(0).cleared = true;
   });
 });

function customerSearch()
{
	var name = $('#cust_name').val();
	var url = '/customers.php?customer-name=' + encodeURIComponent(name);
	window.location = url;
}