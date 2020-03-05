
<?php

$cat_args=array(
    'orderby' => 'name',
    'order' => 'ASC'
);
$categories = get_categories($cat_args);
$url = get_home_url();
?>

<div class="authors-search bg-iu-midnight">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form role="search" method="get" action="<?= $url ?>">
                    <input type="hidden" value="author" name="t" />
                    <input type="hidden" value="0" name="v" />
                    <label for="authorSearch">Search for an Author</label>
                    <div class="input-cont">
                        <input id="authorSearch" aria-label="Author Search" type="text" name="s" placeholder="Search"/>
                        <input type="submit" value=""/>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <form role="search" method="get" action="<?= $url ?>">
                    <label for="authorLetterSearch">View Authors by Alphabet</label>
                    <div class="select-cont">
                        <select id="authorLetterSearch" aria-label="Author Search First Letter of Last Name" name="s">
                            <option value="0">Select First Letter of Last Name</option>
                            <?php foreach(range('a','z') as $i) { ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" value="author" name="t" />
                    <input type="hidden" value="1" name="v" />
                    <input type="submit" style="display:none;" value=""/>
                </form>
            </div>
            <div class="col-md-4">
                <form role="search" method="get" action="<?= $url ?>" style="margin-bottom:0;">
                    <label for="authorBlogSearch">View Authors By Subject</label>
                    <div class="select-cont">
                        <select id="authorBlogSearch" aria-label="Author Search by Blog" name="s">
                            <option value="0">Select a Blog</option>
                            <?php foreach($categories as $category):
                                if ($category->term_id !== 1) {?>
                                    <option value="<?= $category->term_id ?>"><?= $category->name ?></option>
                                <?php }
                            endforeach; ?>
                        </select>
                    </div>
                    <input type="hidden" value="author" name="t" />
                    <input type="hidden" value="2" name="v" />
                    <input type="submit" style="display:none;" value=""/>
                </form>
            </div>
        </div>
    </div>
</div>
