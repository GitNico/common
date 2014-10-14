<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Extended functionality for Kohana Valid
 *
 * @package    OC
 * @category   Security
 * @author     Chema <chema@open-classifieds.com>
 * @copyright  (c) 2009-2013 Open Classifieds Team
 * @license    GPL v3
 */

class Valid extends Kohana_Valid{
    
    
	/**
	* Check an email address for correct format.
	*
	* @param   string   email address
	* @param   boolean  strict RFC compatibility, valid domain with MX, and banned domains if enabled
	* @return  boolean
	*/
	public static function email($email, $strict = FALSE)
	{
		//strict validation
		if ($strict===TRUE)
		{
			//check the RFC compatibility and MX
			return (parent::email($email,TRUE))? Valid::email_domain($email):FALSE;
		}
		//just normal validation
		else
		{
			return parent::email($email);
		}
	}

    /**
     * Validate the domain of an email address by checking if the domain has a
     * valid MX record and is nmot blaklisted as a temporary email
     *
     * @link  http://php.net/checkdnsrr  not added to Windows until PHP 5.3.0
     *
     * @param   string  $email  email address
     * @return  boolean
     */
    public static function email_domain($email)
    {
        if ( ! Valid::not_empty($email))
            return FALSE; // Empty fields cause issues with checkdnsrr()

        $domain = preg_replace('/^[^@]++@/', '', $email);

        if (core::config('general.black_list') == TRUE AND in_array($domain,self::get_banned_domains()))
            return FALSE;

        // Check if the email domain has a valid MX record
        return (bool) checkdnsrr($domain, 'MX');
    }


    /**
     * gets the array of not allowed domains for emails
     * @return array 
     * @see https://github.com/ivolo/disposable-email-domains/blob/master/index.json
     * @author Chema 
     * @date 13/07/2014
     */
    public static function get_banned_domains()
    {
        return array("0-mail.com","0815.ru","0clickemail.com","0wnd.net","0wnd.org","10minutemail.com","20minutemail.com","2prong.com","30minutemail.com","33mail.com","3d-painting.com","4warding.com","4warding.net","4warding.org","60minutemail.com","675hosting.com","675hosting.net","675hosting.org","6url.com","75hosting.com","75hosting.net","75hosting.org","7tags.com","9ox.net","disposableemailaddresses.com","emailmiser.com","putthisinyourspamdatabase.com","sendspamhere.com","spamherelots.com","spamhereplease.com","tempemail.net","a-bc.net","afrobacon.com","ajaxapp.net","amilegit.com","amiri.net","amiriindustries.com","anonbox.net","anonymbox.com","antichef.com","antichef.net","antispam.de","armyspy.com","azmeil.tk","baxomale.ht.cx","beefmilk.com","binkmail.com","bio-muesli.net","bobmail.info","bodhi.lawlita.com","bofthew.com","boun.cr","bouncr.com","brefmail.com","broadbandninja.com","bsnow.net","bugmenot.com","bumpymail.com","casualdx.com","centermail.com","centermail.net","chogmail.com","choicemail1.com","cool.fr.nf","correo.blogos.net","cosmorph.com","courriel.fr.nf","courrieltemporaire.com","cubiclink.com","curryworld.de","cust.in","cuvox.de","dacoolest.com","dandikmail.com","dayrep.com","deadaddress.com","deadspam.com","despam.it","despammed.com","devnullmail.com","dfgh.net","digitalsanctuary.com","discardmail.com","discardmail.de","disposableaddress.com","disposeamail.com","disposemail.com","dispostable.com","dm.w3internet.co.ukexample.com","dodgeit.com","dodgit.com","dodgit.org","donemail.ru","dontreg.com","dontsendmespam.de","drdrb.com","drdrb.net","dump-email.info","dumpandjunk.com","dumpmail.de","dumpyemail.com","e4ward.com","einrot.com","email60.com","emaildienst.de","emailias.com","emailigo.de","emailinfive.com","emailmiser.com","emailsensei.com","emailtemporario.com.br","emailto.de","emailwarden.com","emailx.at.hm","emailxfer.com","emeil.in","emeil.ir","emz.net","enterto.com","ephemail.net","etranquil.com","etranquil.net","etranquil.org","explodemail.com","fakeinbox.com","fakeinformation.com","fastacura.com","fastchevy.com","fastchrysler.com","fastkawasaki.com","fastmazda.com","fastmitsubishi.com","fastnissan.com","fastsubaru.com","fastsuzuki.com","fasttoyota.com","fastyamaha.com","filzmail.com","fizmail.com","fleckens.hu","fr33mail.info","frapmail.com","front14.org","fux0ringduh.com","garliclife.com","get1mail.com","get2mail.fr","getairmail.com","getonemail.com","getonemail.net","ghosttexter.de","girlsundertheinfluence.com","gishpuppy.com","gowikibooks.com","gowikicampus.com","gowikicars.com","gowikifilms.com","gowikigames.com","gowikimusic.com","gowikinetwork.com","gowikitravel.com","gowikitv.com","great-host.in","greensloth.com","grr.la","gsrv.co.uk","guerillamail.biz","guerillamail.com","guerillamail.net","guerillamail.org","guerrillamail.biz","guerrillamail.com","guerrillamail.de","guerrillamail.net","guerrillamail.org","guerrillamailblock.com","gustr.com","h.mintemail.com","h8s.org","haltospam.com","hatespam.org","hidemail.de","hochsitze.com","hotpop.com","hulapla.de","ieatspam.eu","ieatspam.info","ihateyoualot.info","iheartspam.org","imails.info","inbax.tk","inbox.si","inboxalias.com","inboxclean.com","inboxclean.org","incognitomail.com","incognitomail.net","incognitomail.org","insorg-mail.info","ipoo.org","irish2me.com","iwi.net","jetable.com","jetable.fr.nf","jetable.net","jetable.org","jnxjn.com","jourrapide.com","junk1e.com","kasmail.com","kaspop.com","keepmymail.com","killmail.com","killmail.net","kir.ch.tc","klassmaster.com","klassmaster.net","klzlk.com","koszmail.pl","kulturbetrieb.info","kurzepost.de","letthemeatspam.com","lhsdv.com","lifebyfood.com","link2mail.net","litedrop.com","lol.ovpn.to","lookugly.com","lopl.co.cc","lortemail.dk","lr78.com","m4ilweb.info","maboard.com","mail-temporaire.fr","mail.by","mail.mezimages.net","mail2rss.org","mail333.com","mail4trash.com","mailbidon.com","mailblocks.com","mailcatch.com","maildrop.cc","maileater.com","mailexpire.com","mailfa.tk","mailfreeonline.com","mailin8r.com","mailinater.com","mailinator.com","mailinator.net","mailinator2.com","mailincubator.com","mailismagic.com","mailme.ir","mailme.lv","mailmetrash.com","mailmoat.com","mailnator.com","mailnesia.com","mailnull.com","mailshell.com","mailsiphon.com","mailslite.com","mailtothis.com","mailzilla.com","mailzilla.org","mbx.cc","mega.zik.dj","meinspamschutz.de","meltmail.com","messagebeamer.de","mierdamail.com","mintemail.com","moburl.com","moncourrier.fr.nf","monemail.fr.nf","monmail.fr.nf","monumentmail.com","msa.minsmail.com","mt2009.com","mx0.wwwnew.eu","mycleaninbox.net","mypartyclip.de","myphantomemail.com","myspaceinc.com","myspaceinc.net","myspaceinc.org","myspacepimpedup.com","myspamless.com","mytrashmail.com","neomailbox.com","nepwk.com","nervmich.net","nervtmich.net","netmails.com","netmails.net","netzidiot.de","neverbox.com","no-spam.ws","nobulk.com","noclickemail.com","nogmailspam.info","nomail.xl.cx","nomail2me.com","nomorespamemails.com","nospam.ze.tc","nospam4.us","nospamfor.us","nospamthanks.info","notmailinator.com","nowmymail.com","nurfuerspam.de","nus.edu.sg","nwldx.com","objectmail.com","obobbo.com","oneoffemail.com","onewaymail.com","online.ms","oopi.org","ordinaryamerican.net","otherinbox.com","ourklips.com","outlawspam.com","ovpn.to","owlpic.com","pancakemail.com","pimpedupmyspace.com","pjjkp.com","politikerclub.de","poofy.org","pookmail.com","privacy.net","proxymail.eu","prtnx.com","punkass.com","qq.com","quickinbox.com","rcpt.at","reallymymail.com","recode.me","recursor.net","regbypass.com","regbypass.comsafe-mail.net","rejectmail.com","rhyta.com","rklips.com","rmqkr.net","rppkn.com","rtrtr.com","s0ny.net","safe-mail.net","safersignup.de","safetymail.info","safetypost.de","sandelf.de","saynotospams.com","selfdestructingmail.com","sharklasers.com","shiftmail.com","shitmail.me","shortmail.net","sibmail.com","skeefmail.com","slaskpost.se","slopsbox.com","smashmail.de","smellfear.com","snakemail.com","sneakemail.com","sofimail.com","sofort-mail.de","sogetthis.com","soodonims.com","spam.la","spam.su","spam4.me","spamavert.com","spambob.com","spambob.net","spambob.org","spambog.com","spambog.de","spambog.ru","spambox.info","spambox.irishspringrealty.com","spambox.us","spamcannon.com","spamcannon.net","spamcero.com","spamcon.org","spamcorptastic.com","spamcowboy.com","spamcowboy.net","spamcowboy.org","spamday.com","spamex.com","spamfree24.com","spamfree24.de","spamfree24.eu","spamfree24.info","spamfree24.net","spamfree24.org","spamgoes.in","spamgourmet.com","spamgourmet.net","spamgourmet.org","spamhole.com","spamify.com","spaminator.de","spamkill.info","spaml.com","spaml.de","spammotel.com","spamobox.com","spamoff.de","spamslicer.com","spamspot.com","spamthis.co.uk","spamthisplease.com","spamtrail.com","speed.1s.fr","squizzy.de","supergreatmail.com","supermailer.jp","superrito.com","suremail.info","tagyourself.com","teewars.org","teleworm.com","teleworm.us","tempalias.com","tempe-mail.com","tempemail.biz","tempemail.com","tempinbox.co.uk","tempinbox.com","tempmail.it","tempmail2.com","tempomail.fr","temporarily.de","temporarioemail.com.br","temporaryemail.net","temporaryforwarding.com","temporaryinbox.com","thanksnospam.info","thankyou2010.com","thisisnotmyrealemail.com","throwawayemailaddress.com","tilien.com","tmailinator.com","tradermail.info","trash-amil.com","trash-mail.at","trash-mail.com","trash-mail.de","trash2009.com","trashemail.de","trashmail.at","trashmail.com","trashmail.de","trashmail.me","trashmail.net","trashmail.org","trashmail.ws","trashmailer.com","trashymail.com","trashymail.net","trillianpro.com","turual.com","twinmail.de","tyldd.com","uggsrock.com","upliftnow.com","uplipht.com","venompen.com","veryrealemail.com","viditag.com","viewcastmedia.com","viewcastmedia.net","viewcastmedia.org","webm4il.info","wegwerfadresse.de","wegwerfemail.de","wegwerfmail.de","wegwerfmail.net","wegwerfmail.org","wetrainbayarea.com","wetrainbayarea.org","wh4f.org","whatpaas.com","whyspam.me","willselfdestruct.com","winemaven.info","wronghead.com","wuzup.net","wuzupmail.net","www.e4ward.com","www.gishpuppy.com","www.mailinator.com","wwwnew.eu","xagloo.com","xemaps.com","xents.com","xmaily.com","xoxy.net","yep.it","yogamaven.com","yopmail.com","yopmail.fr","yopmail.net","ypmail.webarnak.fr.eu.org","yuurok.com","zehnminutenmail.de","zippymail.info","zoaxe.com","zoemail.org");
    }
}
