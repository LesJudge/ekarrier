<div class="jobSearch-info">
	<div class="jobSearch-info-icon"></div>
        {if $sugok}
        <ul>
        {foreach from=$sugok item=sugo}
                <li>{$sugo.sugo_tartalom}</li>
        {/foreach}
        </ul>
        {else}
                <p>Nincs megjeleníthető elem!</p>
        {/if}
</div>

<div class="jobSearch">
	<img src="images/site/munkakor.jpg" alt="" usemap="#Map">
	<map name="Map" id="Map">
		<area shape="poly" coords="50,360,39,339,30,314,23,287,22,254,21,227,25,201,32,171,51,135,66,106,91,78,111,61,136,43,183,20,227,8,249,8,282,71,251,133,224,141,200,150,178,166,167,183,154,201,148,221,145,251,148,266,151,283,162,300,134,303,92,306" href="{$DOMAIN}munkakorok/" />
		<area shape="poly" coords="255,133,285,72,253,8,278,9,306,14,323,20,342,26,362,36,390,51,403,63,421,81,435,96,448,115,459,128,472,156,479,173,485,200,488,225,491,244,488,270,485,296,480,310,472,338,462,354,438,354,392,351,354,292,358,275,364,256,362,234,362,220,358,204,347,183,347,183,334,169,299,142" href="{$DOMAIN}kompetenciak/" />
		<area shape="poly" coords="52,365,94,309,163,303,174,318,184,328,198,336,211,340,224,348,247,352,264,353,282,349,301,341,314,334,331,322,349,300,388,356,460,359,445,382,429,401,413,417,399,428,382,440,357,453,322,467,299,474,280,476,247,478,220,476,195,472,163,460,137,447,115,431,89,411,69,387" href="{$DOMAIN}munkaltato/" />
		<area shape="circle" coords="255,243,105" href="{$DOMAIN}en/" />
	</map>	
</div>
{*
munkakorok/
kompetenciak/
munkaltato/
en/
*}

<div class="clear"></div>