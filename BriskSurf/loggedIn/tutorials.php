<?php include 'header.php'; ?>
<div class="title">Tutorials</div>
<hr>
<div class="text">
    <center><iframe width="560" height="315" src="http://www.youtube.com/embed/videoseries?list=PLIG_ThJ4bDqHJHBq2YpKhljhnOHXfXaGr&showinfo=1" frameborder="0" allowfullscreen></iframe></center>
    <script>
        $(function() {
        
            // Find all YouTube videos
            var $allVideos = $("iframe[src^='http://www.youtube.com']"),
        
                // The element that is fluid width
                $fluidEl = $("body");
        
            // Figure out and save aspect ratio for each video
            $allVideos.each(function() {
        
                $(this)
                    .data('aspectRatio', this.height / this.width)
                    
                    // and remove the hard coded width/height
                    .removeAttr('height')
                    .removeAttr('width');
        
            });
        
            // When the window is resized
            // (You'll probably want to debounce this)
            $(window).resize(function() {
        
                var newWidth = $("#content .content .text").width();
                if(newWidth > 1000) newWidth = 1000;
                
                // Resize all videos according to their own aspect ratio
                $allVideos.each(function() {
        
                    var $el = $(this);
                    $el
                        .width(newWidth)
                        .height(newWidth * $el.data('aspectRatio'));
        
                });
        
            // Kick off one resize to fix all videos on page load
            }).resize();
        
        });
    </script>
</div>
<?php include 'footer.php'; ?>