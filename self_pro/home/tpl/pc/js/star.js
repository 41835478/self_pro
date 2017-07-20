$(function() {
      $.fn.raty.defaults.path = 'img';
      $('#click-demo').raty({
        click: function(score, evt) {
          console.info('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
        }
      });
     $('#click-demo').css('width','4.8rem');
     $('.star-off-and-star-on-demo').raty({
	        path   : './images',
	        starOff: 'heart_off.png',
	        starOn : 'heart_on.png',
        	click: function(score, evt) {
          console.info('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
        }
      });
        $('.star-off-and-star-on-demo').css('width','4.8rem')
    });