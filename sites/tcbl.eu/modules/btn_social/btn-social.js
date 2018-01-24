/**
 * Btn Social
 */

jQuery().ready(function(){
  jQuery('.link-to-social').click(function(e){
    e.preventDefault();
    hr = jQuery(this).attr('href');
    window.open(hr,'mywin','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500,height=500');
  });

  jQuery('.a-share').click(function(e){
    e.preventDefault();
    jQuery(this).next().toggleClass('visible');
  });
});
