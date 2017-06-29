<div class="post"> 

  <h2><?php echo $currset['title']?></h2> 

  <p><?php echo $currset['description']?></p> 

</div>
<ul> 

  <?php foreach($sets['photoset'] AS $item): ?> 

  <li><?php echo $this->Html->link($item['title'], '/flickrs/' . $item['id']);?></li>  

  <?php endforeach; ?> 

</ul>
<img id="mainimg" src="<?php echo $flickr->buildPhotoURL($thumbs['photo'][0], 'medium')?>" title="<?php echo
$thumbs['photo'][0]['title']?>"  alt="<?php echo  
$thumbs['photo'][0]['title']?>" />
<ul id="thumbs"> 

  <?php foreach($thumbs['photo'] as $item): ?> 

  <li><a href="<?php echo $flickr->buildPhotoURL($item, "medium")?>" title="<?php echo $item['title']?>"><img  

        src="<?php echo $flickr->buildPhotoURL($item, "thumbnail")?>"  

        alt="<?php echo $item['title']?>" /></a></li> 

  <? endforeach; ?> 

</ul>