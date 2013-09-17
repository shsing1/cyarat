                    <div id="box_menu">
                        <ul>
                            <?php foreach ($main_nav as $k=>$v) {?>
                            <li class="menu_0<?php echo ($k + 1);?> <?php if($v['current']){ ?>click<?php } ?>"><a href="<?php echo $v['url'];?>"><?php echo $v['name'];?></a></li>
                            <?php }?>
                        </ul>
                    </div>