<?php
                
header('content-type: text/xml');
                

$md = new CMarkdownParser;

$url = Config::instance()->siteUrl;

echo '<?xml version="1.0"?>';
?>

<rss version="2.0">
	<channel>
		<title><![CDATA[<?php echo Yii::app()->name; ?>]]></title>
		<link><![CDATA[<?php echo $url; ?>]]></link>
		<description><![CDATA[<?php echo Config::instance()->rssDescription; ?>]]></description>
		<image>
			<url><![CDATA[<?php echo $url; ?>/images/feedlogo.gif]]></url>
			<title><![CDATA[<?php echo Yii::app()->name; ?>]]></title>
			<link><![CDATA[<?php echo $url; ?>]]></link>
		</image>
		<language>en-us</language>
		<copyright>Copyright <?php echo date('Y'); ?> Ben Rowe</copyright>
		<?php foreach ($items as $item): ?>
		<item>
			<title><![CDATA[<?php echo $item->title; ?>]]></title>
			<link><![CDATA[<?php echo $item->permaUrl; ?>]]></link>
			<guid isPermaLink="true"><![CDATA[<?php echo $item->permaUrl; ?>]]></guid>
			<!--<comments><?php echo $item->permaUrl; ?>#comments</comments>-->
			<description><![CDATA[<?php echo $md->transform($item->body); ?>]]></description>
			<?php foreach ($item->tags as $tag): ?>
				<category><?php echo $tag; ?></category>
			<?php endforeach; ?>
			<pubDate><?php echo $item->getDatePublished(true)->format('D, d M Y H:i:s T'); ?></pubDate>
		</item>
		<?php endforeach; ?>
	</channel>
</rss>