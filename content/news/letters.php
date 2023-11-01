<?php
switch ($LANG["language"]["shortname"])
{
	case "de": 
		$lang_id = 1; 
		$month = array('01'=>'Januar','02'=>'Februar','03'=>'März','04'=>'April','05'=>'Mai','06'=>'Juni','07'=>'Juli','08'=>'August','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Dezember');
		break; 
	case "en": $lang_id = 2;
		$month = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May', '06'=>'June', '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
		break;
}
if(!isset($LANG["language"]["shortname"])){
	$lang_id = 1; 
		$month = array('01'=>'Januar','02'=>'Februar','03'=>'März','04'=>'April','05'=>'Mai','06'=>'Juni','07'=>'Juli','08'=>'August','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Dezember');
}

if(empty($content[2]) or (!empty($content[2]) and $content[2] == 'archiv'))
{
	
	$news_array = $DB->select('SELECT *, DATE_FORMAT(`letter_date`, "%m") as `month`, DATE_FORMAT(`letter_date`, "%Y") as `year` FROM newsletter_letters WHERE language_id = '.$lang_id.' AND id NOT IN(373, 374)  ORDER BY `letter_date` DESC LIMIT 10');

	if (isset($content[2]) and $content[2] == 'archiv')
	{
		$str = "0";
		foreach($news_array as $val)
			$str .= ",'".$val['id']."'";

	//	$news_array = $DB->select('SELECT  DISTINCT(letter_subject) FROM `newsletter_letters` WHERE `language_id` = '.$lang_id.' AND `id` NOT IN ('.$str.') ORDER BY `letter_date` DESC');
		$news_array = $DB->select('SELECT  * FROM `newsletter_letters` WHERE `language_id` = '.$lang_id.' AND `id` NOT IN ('.$str.') GROUP by letter_subject ORDER BY `letter_date`  DESC');
	}
	
	
	if (isset($content[2]) and $content[2] == 'archiv')
	{
		$li = '<li>';
		$li2 = '</li>';
		
	}
	
	else {
		//$li3 = '<p><strong>'.$month[$news_entity["month"]].' '.$news_entity["year"].'</strong></p>';
		$a_cl=' class="one-letter-link"';
	}
	
	
	
	
	if ($news_array)
	{
		foreach ($news_array as $news_entity)
		{ 
			if ($news_entity["letter_subject"])
			{
				$news .= $li.'<a'.$a_cl.' href="/news/letters/'.$news_entity["id"].'/">'.$news_entity["letter_subject"].'</a>'.$li2.$li3;
				
				//<p>
				//<strong>'.$month[$news_entity["month"]].' '.$news_entity["year"].'</strong>
				//</p>'.(($content[2] == 'archiv') ? '' : ''.cut_txt(strip_tags($news_entity["letter_text"]),300).'<br>').'
				//<br>';
			}
		}
	}
	else 
	{
		switch ($LANG["language"]["shortname"])
		{
			case "de": $news = 'Es wurden keine Newsletter gefunden<br><br>'; 
				break; 
			case "en": 
				$news = 'No Newsletters found!<br><br>'; 
				break;
		}
	}

	switch ($LANG["language"]["shortname"])
	{
		case "de":
		$archiv = ($content[2] == 'archiv') ? '' : '<a class="newslettersarchivelink" href="'.$URL_ROOT.'news/letters/archiv/">Newsletter Archiv</a>';
		$html = '
		<div class="partnernet newsletter">

			<div class="h1">
			<div class="shadow"></div>
				<div class="wrapper">
					<div class="h1-text">
						NEWSLETTER '.(($content[2] == 'archiv') ? ' ARCHIV' : '').'
					</div>

					<div class="h1-photo">
					<div class="shadow-img"></div>
						<img src="/images/Frowein_01SP_News_Newsletters2.png" alt="">
					</div>
				</div>
			</div>

			<div class="wrapper">
				<div class="crumbs">
					<span>Home</span> - <span>NEWSLETTER '.(($content[2] == 'archiv') ? ' ARCHIV' : '').'</span>
				</div>
			</div>
			<div class="part-bg">
				<div class="partner-bg">
					<img src="/images/insect_info_right.png" alt="">
				</div>
			</div>

			<div class="wrapper">
			
			<div id="blog_content2"><br clear="all" />
			<ul>
				'.$news.'
			</ul>
			<p>'.$archiv.'</p>
			</div>
			<div class="sn">
							<a href="http://www.facebook.com/frowein808"><img src="/images/fb.png" alt=""></a>
							<a href="http://www.frowein808.blogspot.com/"><img src="/images/blogspot.png" alt=""></a>
							<a href="http://www.youtube.com/user/FroweinGmbH?feature=mhum"><img src="/images/youtube2.png" alt=""></a>
							<a href="https://plus.google.com/u/0/116988004659615177800/posts#116988004659615177800/posts"><img src="/images/google.png" alt=""></a>
							<a href="https://www.xing.com/companies/froweingmbh%252526co.kg?trkid=us%3afcd048176169ca9ea415e079f0154758%3ad41d8cd98f00b204e9800998ecf8427e%3acompanies;trkoff=0"><img src="/images/x.png" alt=""></a>
							<a href="http://www.linkedin.com/company/frowein-gmbh-&-co-kg?trk=hb_tab_compy_id_2876431"><img src="/images/in.png" alt=""></a>
							<a href="http://twitter.com/frowein808"><img src="/images/tw.png" alt=""></a>
							<a href="https://www.pinterest.com/frowein808/"><img src="/images/pinterest.png" alt=""></a>
						</div>
        </div>
    </div>

    <div class="clr"></div>


</div>
';
			break;
		case "en":
		$archiv = ($content[2] == 'archiv') ? '' : '<a class="newslettersarchivelink" href="'.$URL_ROOT.'news/letters/archiv/">Newsletters Archive</a>';
		$html ='<div class="partnernet newsletter">

			<div class="h1">
			<div class="shadow"></div>
				<div class="wrapper">
					<div class="h1-text">
						NEWSLETTERS '.(($content[2] == 'archiv') ? ' ARCHIVE' : '').'
					</div>

					<div class="h1-photo">
					<div class="shadow-img"></div>
						<img src="/images/Frowein_01SP_News_Newsletters2.png" alt="">
					</div>
				</div>
			</div>

			<div class="wrapper">
				<div class="crumbs">
					<span>Home</span> - <span>NEWSLETTERS '.(($content[2] == 'archiv') ? ' ARCHIVE' : '').'</span>
				</div>
			</div>
			<div class="part-bg">
				<div class="partner-bg">
					<img src="/images/insect_info_right.png" alt="">
				</div>
			</div>

			<div class="wrapper">
			
			<div id="blog_content2"><br clear="all" />
				<ul>
				'.$news.'
			</ul>
			<p>'.$archiv.'</p>
			</div>
			<div class="sn">
							<a href="http://www.facebook.com/frowein808"><img src="/images/fb.png" alt=""></a>
							<a href="http://www.frowein808.blogspot.com/"><img src="/images/blogspot.png" alt=""></a>
							<a href="http://www.youtube.com/user/FroweinGmbH?feature=mhum"><img src="/images/youtube2.png" alt=""></a>
							<a href="https://plus.google.com/u/0/116988004659615177800/posts#116988004659615177800/posts"><img src="/images/google.png" alt=""></a>
							<a href="https://www.xing.com/companies/froweingmbh%252526co.kg?trkid=us%3afcd048176169ca9ea415e079f0154758%3ad41d8cd98f00b204e9800998ecf8427e%3acompanies;trkoff=0"><img src="/images/x.png" alt=""></a>
							<a href="http://www.linkedin.com/company/frowein-gmbh-&-co-kg?trk=hb_tab_compy_id_2876431"><img src="/images/in.png" alt=""></a>
							<a href="http://twitter.com/frowein808"><img src="/images/tw.png" alt=""></a>
							<a href="https://www.pinterest.com/frowein808/"><img src="/images/pinterest.png" alt=""></a>
						</div>
        </div>
    </div>

    <div class="clr"></div>


</div>
';
	}
}
else
{
	if(!isset($lang_id)){
		$lang_id = 1;
	}

	$one_news = $DB->select('SELECT * FROM newsletter_letters WHERE language_id = '.$lang_id.' AND `id`='.(int)$content[2].' ORDER BY `id` DESC LIMIT 1');
	if ($one_news)
	{
		foreach ($one_news as $news_entity)
		{
			$news .= '<br>'.$news_entity["letter_text"].'<br><br>';
		 if ($news_entity['letter_picalign']==0) $align = "left"; else $align = "right";
                $pic = '<img src="http://www.frowein808.de/uploads/'.$news_entity['letter_picture'].'" style="width:100%; border:0; float:'.$align.';" alt="">';
                $news=str_replace('[BILD]',$pic,$news);

		}
		
				
			
		switch ($LANG["language"]["shortname"])
		{
			case "de":
			$html = '<div class="partnernet one-letter">

    <div class="h1">
	<div class="shadow"></div>
        <div class="wrapper">
            <div class="h1-text">
              NEWSLETTER '.(($content[2] == 'archiv') ? ' ARCHIVE' : '').'
            </div>

            <div class="h1-photo">
			<div class="shadow-img"></div>
                <img src="/images/Frowein_01SP_News_Newsletters2.png" alt="">
            </div>
        </div>
    </div>

    <div class="wrapper">
        <div class="crumbs">
            <span>Home</span> - <span>'.$news_entity["letter_subject"].'</span>
        </div>
    </div>			
				 <div class="wrapper">
				<div id="blog_content2">
				<div class="h2">'.$news_entity["letter_subject"].'</div>
				
					'.$news.'</div>
					
        </div>
        </div>
    </div>

    <div class="clr"></div>


</div>
';
				break;
			case "en":
			$html ='<div class="partnernet one-letter">

    <div class="h1">
	<div class="shadow"></div>
        <div class="wrapper">
            <div class="h1-text">
              NEWSLETTERS '.(($content[2] == 'archiv') ? ' ARCHIVE' : '').'
            </div>

            <div class="h1-photo">
			<div class="shadow-img"></div>
                <img src="/images/Frowein_01SP_News_Newsletters2.png" alt="">
            </div>
        </div>
    </div>

    <div class="wrapper">
        <div class="crumbs">
            <span>Home</span> - <span>'.$news_entity["letter_subject"].'</span>
        </div>
    </div>
			 <div class="wrapper">	
				<div id="blog_content2">
				<div class="h2">'.$news_entity["letter_subject"].'</div>
				
				
				
					'.$news.'</div>
        </div>
        </div>
    </div>
    <div class="clr"></div>
</div>
';
		}
	}
}

