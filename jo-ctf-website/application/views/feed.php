<div class="col-md-12 contwrap">
    <div class="col-md-offset-1 col-md-10 contcontain">
        <?php
        $i=0; $j=1;
        foreach ($postlist as $post) {
            $j = min($j, $post->id);
            if ($i == 0) {
                echo '<div class="row">';
            }
            ?>

            <div class="col-md-4 content">
                <div class="col-md-12 contimg">
                    <img src="<?php echo $target . $post->image; ?>">
                </div>
                <div class="col-md-12 contarea">
                    <h3><?php echo $post->title; ?></h3>
                    <h4><?php echo $post->author; ?></h4>
                    <h5><?php echo $post->data; ?></h5>
                    <hr>
                    <p><?php echo $post->content; ?></p>
                    <a class="col-md-offset-2 col-md-8 readbtn"
                       href="<?php echo base_url('/user/readPost/?id=') . $post->id; ?>">Read</a>
                </div>
            </div>
            <?php
            $i++;
            if ($i == 3) {
                echo "</div>";
                $i = 0;
            }
        }?>
        <div id="replace">
            <input type="hidden" id="morep" value="<?php echo $j; ?>">
        </div>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <button class="col-md-offset-2 col-md-8 ldbtn">Load More</button>
    </div>
</div>
