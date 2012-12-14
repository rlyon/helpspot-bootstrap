<?php
//Inform browser that this is XML
header('Content-type: text/xml');

//Access forum information
$this->forum = $this->splugin('Forums_Topics','getForum',$this->get_id);

//Security - $this->forum returns false if get_id is not valid or is for a private forum. Also check to see if portal feeds are enabled.
if(!$this->forum || !$this->hd_forumFeedsEnabled) exit();

//NOTE: $this->hd_feedCharSet is derived from the variable lg_feedcharset at the top of your language pack file located at helpspot/lang/
?>

<?php echo '<?xml version="1.0" encoding="'.$this->hd_feedCharSet.'"?>' ?>
<rss version="2.0">
    <channel>
        <title><?php echo $this->forum['sForumName'] ?></title>
        <description></description>
        <copyright><?php echo $this->hd_feedCopyright ?></copyright>
        <link><?php echo $this->hd_hostURL ?>/index.php?pg=forums.topics&amp;id=<?php echo $this->get_id ?></link>
        <generator><?php echo $this->hd_name ?></generator>

		<?php foreach($this->splugin('Forums_Topics','getFeedTopics', $this->get_id, $this->get_start) AS $topic): ?>
        <item>
            <title><?php echo $topic['sTopic'] ?></title>
            <link><?php echo $this->hd_hostURL ?>/index.php?pg=forums.posts&amp;id=<?php echo $topic['xTopicId'] ?>&amp;pc=<?php echo $topic['postcount'] ?></link>
            <description><![CDATA[ <?php echo $topic['feeddescription'] ?>  ]]></description>
            <guid><?php echo $this->hd_hostURL ?>/index.php?pg=forums.posts&amp;id=<?php echo $topic['xTopicId'] ?></guid>
            <pubDate><?php echo $this->helper->RSSDate($topic['dtGMTPosted']) ?></pubDate>
        </item>
        <?php endforeach; ?>
        
    </channel>
</rss>        