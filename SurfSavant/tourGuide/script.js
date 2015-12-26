/*
|--------------------------------------------------------------------------
| Tour Guide by Daniel Heyman
|--------------------------------------------------------------------------
*/

$(document).ready(function() {
    $("body").append('<div id="tourOverlay"></div><div id="tourArrow"></div><div id="tourTip"></div><a id="tourClose"><i class="icon-remove"></i></a>');
});
function TourGuide(name, elements, onComplete){
    this.name = name;
    this.onComplete = onComplete;
    this.elements = elements;
    this.lastnumber = -1;
    this.number = 0;
    $("#tourClose").attr("href", "javascript:" + this.name + ".close();");
} 
TourGuide.prototype.setCookie = function(c_name,value,exdays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}
TourGuide.prototype.start = function(){
    this.lastnumber = -1;
    this.number = 0;
    this.loadNext();
}
TourGuide.prototype.close = function(){
    this.number = 9999999;
    this.loadNext();
}
TourGuide.prototype.loadNext = function(){
    if($("#tourOverlay").css("display") == "block")
    {
        var element = this.elements[this.lastnumber][0];
        $("#tourOverlay").fadeOut(500);  
        if(element != "-") $("#tourArrow").fadeOut(500);  
        $("#tourClose").fadeOut(500);  
        var that = this;
        $("#tourTip").fadeOut(500, function() {
            if(element != "-") $(element).removeClass("tourElement");
            if(that.elements.length > that.number) that.loadNext(); 
            else if(that.number != 9999999) that.onComplete();
        }); 
        return;
    }
    
    var type = this.elements[this.number][1];
    var element = (type != "center") ? this.elements[this.number][0] : "-";
    var text = this.elements[this.number][2];
    var showNext = (this.elements[this.number].length > 3) ? this.elements[this.number][3] : true;
    var width = (this.elements[this.number].length > 4) ? this.elements[this.number][4] : 300;
    var stepFunction = (this.elements[this.number].length > 5) ? this.elements[this.number][5] : function() {};
    
    stepFunction();
    
    if(showNext) text += '<br><a href="javascript:' + this.name + '.loadNext();" class="nextbutton">' + ((this.elements.length > this.number + 1) ? 'Next' : 'Finish') + '</a>';
    
    $("#tourTip").css("max-width", width + "px");
    $("#tourTip").html(text);
    
    if(type == "right")
    {
        var top = $(element).offset().top + $(element).outerHeight() / 2 - $("#tourTip").outerHeight() / 2;
        var left = $(element).offset().left + $(element).outerWidth() + 30;
        var top2 = top + $("#tourTip").outerHeight() / 2 - 10;
        var left2 = left - 10;
        $("#tourArrow").attr("class", "right");
    }
    else if(type == "right-top")
    {
        var top = $(element).offset().top;
        var left = $(element).offset().left + $(element).outerWidth() + 30;
        if($(element).outerHeight() < $("#tourTip").outerHeight()) top += $(element).outerHeight() / 2 - $("#tourTip").outerHeight() / 2;
        var top2 = top + $("#tourTip").outerHeight() / 2 - 10;
        var left2 = left - 10;
        $("#tourArrow").attr("class", "right");
    }
    else if(type == "left")
    {
        var top = $(element).offset().top + $(element).outerHeight() / 2 - $("#tourTip").outerHeight() / 2;
        var left = $(element).offset().left - 30 - $("#tourTip").outerWidth();
        var top2 = top + $("#tourTip").outerHeight() / 2 - 10;
        var left2 = left + $("#tourTip").outerWidth();
        $("#tourArrow").attr("class", "left");
    }
    else if(type == "left-top")
    {
        var top = $(element).offset().top;
        if($(element).outerHeight() < $("#tourTip").outerHeight()) top += $(element).outerHeight() / 2 - $("#tourTip").outerHeight() / 2;
        var left = $(element).offset().left - 30 - $("#tourTip").outerWidth();
        var top2 = top + $("#tourTip").outerHeight() / 2 - 10;
        var left2 = left + $("#tourTip").outerWidth();
        $("#tourArrow").attr("class", "left");
    }
    else if(type == "top")
    {
        var top = $(element).offset().top - $("#tourTip").outerHeight() - 30;
        var left = $(element).offset().left + $(element).outerWidth() / 2 - $("#tourTip").outerWidth() / 2;
        var top2 = top + $("#tourTip").outerHeight();
        var left2 = left + $("#tourTip").outerWidth() / 2 - 10;
        $("#tourArrow").attr("class", "top");
    }
    else if(type == "bottom")
    {
        var top = $(element).offset().top + $(element).outerHeight() + 30;
        var left = $(element).offset().left + $(element).outerWidth() / 2 - $("#tourTip").outerWidth() / 2;
        var top2 = top - 8;
        var left2 = left + $("#tourTip").outerWidth() / 2 - 10;
        $("#tourArrow").attr("class", "bottom");
    }
    else if(type == "center")
    {
        var top = $(window).height() / 2 - $("#tourTip").outerHeight() / 2;
        var left = $(window).width() / 2 - $("#tourTip").outerWidth() / 2;
        var top2 = -100;
        var left2 = -100;
        $("#tourArrow").css("class", "center");
    }
    if(element != "-") scroll = (top < $(element).offset().top) ? top : $(element).offset().top;
    else scroll = 0;
    $("html, body").animate({ scrollTop: scroll - 30 });
    if(element != "-") $(element).addClass("tourElement");
    $("#tourTip").css({"top": top, "left": left});
    $("#tourArrow").css({"top": top2 , "left": left2});
    $("#tourClose").css({"top": top - 2, "left": left + $("#tourTip").outerWidth() - 18});
    $("#tourOverlay").fadeIn(500);   
    $("#tourTip").fadeIn(500);  
    $("#tourArrow").fadeIn(500); 
    $("#tourClose").fadeIn(500); 
    this.number++;
    this.lastnumber++;
}