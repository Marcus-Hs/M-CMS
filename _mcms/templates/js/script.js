if (self != top) top.location.href=self.location.href;
var count = 0; // needed for safari
setTimeout(function(){count = 1;},200);
$(function() {
   $(window).unload(function() {
      var scrollPosition = $(window).scrollTop();
      localStorage.setItem("scrollPosition", scrollPosition);
   });
   if(localStorage.scrollPosition) {
		// managage back button click (and backspace)
    if (typeof history.pushState === "function") {
        history.pushState("back", null, null);
        window.onpopstate = function () {
            history.pushState('back', null, null);
            if(count == 1){
							$(window).scrollTop(localStorage.getItem("scrollPosition"));
						}
         };
     }
      
   }
});
