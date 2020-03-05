
<?php

$url = get_home_url();
?>

  <div id="search-news">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <form role="search" method="get" action="<?= $url ?>">
              <input type="hidden" value="news" name="t" />
              <input type="hidden" value="0" name="v" />
              <label for="newsCampusSearch">Search News</label>
              <div class="input-cont">
                  <input id="newsSearch" aria-label="News Search" type="text" name="s" placeholder="Search"/>
                  <input type="submit" value=""/>
              </div>
          </form>
        </div><!-- search bar -->
        <div class="col-md-3">
          <form role="search" method="get" action="<?= $url ?>">
            <label for="newsCampusSearch">Campus News</label>
              <div class="select-cont">
                <select id="newsCampusSearch" aria-label="Campus News" name="s">
                  <option value="0">
                    Please Select Campus
                  </option>
                  <option value="Bloomington">
                    Bloomington
                  </option>
                  <option value="Evansville">
                    Evansville
                  </option>
                  <option value="Fort Wayne">
                    Fort Wayne
                  </option>

                  <option value="Indianapolis">
                    Indianapolis
                  </option>
                  <option value="Muncie">
                    Muncie
                  </option>

                  <option value="Gary">
                    Gary
                  </option>

                  <option value="South Bend">
                    South Bend
                  </option>
                  <option value="Terre Haute">
                    Terre Haute
                  </option>
                  <option value="West Lafayette">
                    West Lafayette
                  </option>


                </select>
              </div>
              <input type="hidden" value="news" name="t" />
              <input type="hidden" value="1" name="v" />
              <input type="submit" style="display:none" value="" />
          </form>
        </div><!-- middle dropdown -->
        <div class="col-md-3">
          <form role="search" method="get" action="<?= $url ?>" style="margin-bottom:0;">
              <label for="newsDepartment">Department News</label>
              <div class="select-cont">
                  <select id="newsDepartment" aria-label="Department News" name="s">
                      <option value="0">Select a Department</option>
                      <option value="Cancer">Cancer</option>
                      <option value="Cardiovasular">Cardiovasular</option>
                      <option value="Clinical Trials">Clinical Trials</option>
                      <option value="Womens Health">Women's Health</option>
                      <option value="Cancer Center">IU Simon Cancer Center</option>
                      <option value="Sound Medicine">Sound Medicine</option>




                  </select>
              </div>
              <input type="hidden" value="news" name="t" />
              <input type="hidden" value="3" name="v" />
              <input type="submit" style="display:none;" value=""/>
          </form>
        </div><!-- middle dropdown -->
        <div class="col-md-3">
          <form role="search" method="get" action="<?= $url ?>" style="margin-bottom:0;">
              <label for="newsTopic">Topics</label>
              <div class="select-cont">
                  <select id="newsTopic" aria-label="Topic News" name="s">
                      <option value="0">Select a Topic</option>
                    <?php
                    //loop through departments
                    $tags = get_tags();
                    foreach($tags as $tag ){
                      $tag_link = get_tag_link( $tag->term_id );

                      ?>
                      <option value="<?= $tag->name ?>">
                        <?php echo $tag->name; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select>
              </div>
              <input type="hidden" value="news" name="t" />
              <input type="hidden" value="4" name="v" />
              <input type="submit" style="display:none;" value=""/>
          </form>
        </div><!-- last dropdown -->
      </div>
    </div>
  </div>
