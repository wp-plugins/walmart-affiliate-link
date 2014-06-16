<?php

function wmt_admin_page() {

  global $wmt_options;
  ob_start(); 
  ?>
  <div style="background-color:rgb(2, 83, 155);margin-left:10px;">
  <?php
  echo '<img src="' . plugins_url( 'images/Walmart-Affiliate-Link.gif' , __FILE__ ) . '" > ';
  ?>
</div>
<div style="margin-left:5px;margin-top:20px;font-size:15px;">
Congratulations! you are just one step away from using this plugin. This plugin lets you easily create paid links to Walmart.com.
<div class="wrap"> 
  <h3 style="color: rgb(2, 83, 155);">What is Walmart Affiliate Link (WAL)? </h3>
  This plugin lets you easily create trackable links to Walmart.com. Developed by Walmart for its affiliate partners, this easy to use plugin lets you create paid links by setting your Linkshare id for payment into your account. To use this plugin you must have already registered with Walmart as an Affiliate Partner. More information at http://affiliates.walmart.com.
  Whenever your blog post contains text that matches a set pattern, it gets converted to a paid Walmart.com link. Given the wide assortment of products at Walmart, there is a high chance your content is converted to paid links with this plugin.
</div>

<div class="wrap"> 
  <h3 style="color: rgb(2, 83, 155);">Plugin Setup</h3>
 Please configure your walmart affiliate link generator. (Just one field.)
</div>

<div style="border:2px solid #a1a1a1;padding:10px;margin:10px;background:#dddddd;border-radius:20px;width:400px;">
    <form action="options.php" method="post">
      <?php settings_fields('wmt_settings_group'); ?>
      <p style="font-size:20px;">
         <label class="description" for="wmt_settings[encrypted]">Linkshare id</label>
         <input id="wmt_settings[encrypted]" name="wmt_settings[encrypted]" type="text" value="<?php echo $wmt_options['encrypted']; ?>"/>
      </p>
      <p>
         <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
      </p>
    </form>
</div>

<div>
  <div style="margin-top:20px;padding:10px 40px;width:800px;">
  Steps to obtain your Linkshare id :  
    <ol>
      <li>Login to your linkshare account on Walmart Affiliate Link (<a href='https://affiliates.walmart.com'>https://affiliates.walmart.com</a>) using Linkshare single sign-on feature.</li>
      <li>Navigate to the tools section and browse through our widgets.</li>
      <li>In the popup that opens up (upon click on any of the widgets eg. bestseller) on the top right corner you will find you Linkshare id.</li>
    </ol>
  </div>
 

<div style="margin-top:20px;">
  <h3 style="color: rgb(2, 83, 155);">How to use the plugin? </h3>
  The following are supported formats in this wordpress plugin.
  <div style="margin-top:10px;"></div>
  <style>
  table,th,td
  {
    border:2px solid #a1a1a1;
    border-collapse:collapse;
    border-spacing:5px;
    border-radius:20px;
    width:1000px;
    height:120px;
    padding:10px;
  }
  </style>

  <table>
   <thead>
      <tr>
         <th style="height:20px;">Pattern</th>
         <th style="height:20px;">Description</th>
      </tr>
   </thead>
    <tr>
      <td>
        Pattern : <br><br>[walmart&lt;space&gt;search&lt;space&gt;&lt;search query&gt;]<br><br>
        eg. [walmart search ipad] takes you to the search results page for iPad on Walmart.com
      </td>
      <td>
        Lets you create links to search pages on walmart.com.        
      </td>      
    </tr>
    <tr>
      <td>
        Pattern : <br><br>
        [walmart&lt;space&gt;url&gt;&lt;space&gt;&lt;title&gt;]<br><br>
        eg. [walmart http://walmart.com/ Walmart Homepage]
      </td>
      <td>
        Lets you create links to any Walmart.com page.
      </td>      
    </tr>
    <tr>
      <td>
        Pattern : <br><br>
        [walmart&lt;space&gt;banner&lt;space&gt;&lt;item id&gt;]<br><br>
        eg. [walmart banner 123123123]
      </td>
      <td>
        Lets you create a banner for a specific product.<br>
        You can obtain the walmart item id by browsing the site. Walmart.com item pages urls adhere to the following format.<br><br>
        <i>http://www.walmart.com/ip/&lt;title of the item&gt;/&lt;item id&gt;<br><br></i>
        eg. In the url : <i>http://www.walmart.com/ip/Garanimals-Newborn-Boys-21-Piece-Layette-Set/22955038</i><br>
        22955038 is the item id.

      </td>      
    </tr>    
  </table>
 <div style="margin-top:10px;">
    Please test all your links to ensure they redirect to Walmart.com after publishing.
  </div>
  <div style="margin-top:20px;">Have feedback or need more features? Please write to us at <a target="_top" href="mailto:affiliates@walmart.com">affiliates@walmart.com</a></div>
  </div>
</div>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51915563-1', 'affil.walmart.com');
  ga('send', 'pageview');

</script>
<?php
  echo ob_get_clean();
}

function wmt_add_admin_page(){ 
  add_options_page("Walmart Affiliate Link Generator Admin page", "Walmart Affiliate Link", "manage_options", "wal-admin", "wmt_admin_page");
}
add_action("admin_menu", "wmt_add_admin_page");

function wmt_register_settings() {
  register_setting("wmt_settings_group", "wmt_settings");
}

add_action("admin_init", "wmt_register_settings");

?>