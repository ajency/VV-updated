<?php
	$effects = array("fade","scrollVert","scrollHorz","zoom","scrollUp","scrollDown","shuffle");
	$duration = 500;
	
	if(isset($_GET['dur'])){
		$duration = (is_numeric($_GET['dur']))? intval($_GET['dur']) : $duration;
	}
?>
/*
*/

// JavaScript Documentvar 
var $j = jQuery.noConflict();
$j(document).ready(function () {
	
	//define the needed variable
	var dur = <?php echo $duration;?>;
	var currel = 0;
	var conresizable = 1;
	// Don't execute code if it's IE6 or below cause it doesn't support it.
	if ($j.browser.msie && $j.browser.version < 7) return;
	
	//use jQuery cycle to make the effect
    <?php 
	for($i=0;$i<count($effects);$i++){
		$j = '$j';
		$cycletext = "
		$j('.testimonials-slider-".$effects[$i]."').cycle({
			timeout :0,
			speed : dur,
			startingSlide : 0,
			fx : '".$effects[$i]."',
			containerResize : conresizable
		});
		\n\n";
		echo $cycletext;
	}
	?>

	$j(".testimonials-slider-quotecontainer").each(function(id, obj){
		// retrieve all elements dimension
		var heightcontents = new Array();
		var quotecontent = $j(".testimonials-slider-quotecontent", obj);
		quotecontent.each(function(idx,el){
			heightcontents[idx] = el.offsetHeight;
		});
		//define the quotecontainer height with first current element
		$j(obj).css({'height' : heightcontents[currel]+'px'});
	});
	
	//when the thumbslide is clicked
	$j(".testimonials-slider-thumbslide").click(function(){
		var idx = parseInt($j(this).attr("title"));
		var clone_idx = $j(this).attr("rel"); // clone_id fix: Alexander 30.11.2011

		if (clone_idx != '') {
			var el = "." + clone_idx + " .testimonials-slider-quotecontainer";
		} else {
			var el = "#testimonials-slider-quotecontainer";
		}

		var heightcontents = new Array();
		var quotecontent = $j(".testimonials-slider-quotecontent", $j(el));
		quotecontent.each(function(id,obj){
			$j(obj).show();
			heightcontents[id] = obj.offsetHeight;
			// $j(obj).hide();
		});
		
		$j(el).cycle(idx);
		$j(el).animate({
			'height' : heightcontents[idx]+'px'
		},dur,'linear');
		return false;
	});
	
	$j(".testimonials-slider-thumbcont").walkingPointer({speed : dur});
	
});

// function to make the pointer moving
$j = jQuery.noConflict();
(function($j) {
$j.fn.walkingPointer = function(o) {
    o = $j.extend({ fx: "linear", speed: 500, click: function(){} }, o || {});

    return this.each(function() {
        var me = $j(this), noop = function(){},
            $pointer = $j('.testimonials-slider-pointer'),
            $thumbslide = $j(".testimonials-slider-thumbslide", this), curr = $j(".tscurrentpointer", this)[0] || $j($thumbslide[0]).addClass("tscurrentpointer")[0], bgPos;
		var unusedLeft = $thumbslide[0].offsetLeft;
		var stcPointer = 7;
		
        $j(this).click(noop);

        $thumbslide.click(function(e) {
			move(this);
			$thumbslide.removeClass("tscurrentpointer");
			$j(this).addClass("tscurrentpointer");
			curr = $j(this);
            return o.click.apply(this, [e, this]);
        });

        setCurr(curr);

        function setCurr(el) {
			var halfwidth = el.offsetWidth/2;
			halfwidth = parseInt(halfwidth);
			bgPos = el.offsetLeft + halfwidth - unusedLeft - stcPointer;
			
			var clone_idx = $j(el).attr("rel"); // clone_id fix: Alexander 30.11.2011
			if (clone_idx != '') {
				$pointer = $j("." + clone_idx + ' .testimonials-slider-pointer');
			} else {
				$pointer = $j('#testimonials-slider-pointer');
			}
            $pointer.css({ 'background-position': bgPos+"px 0px"});
            curr = el;
        };

        function move(el) {
			setCurr(el);
            $pointer.each(function() {
                $j(this).dequeue(); }
            ).animate({
                backgroundPosition: bgPos+"px 0px"
            }, o.speed, o.fx);
        };
    });
};
})(jQuery);