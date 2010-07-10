				<form method="method" tal:attributes="action string:${application/site_root}/search" action="search">
					<input type="text" class="text" name="q" value="Aranacak kelimeyi giriniz..." 
                            onfocus="this.value='';"  
                            onblur="this.value='Aranacak kelimeyi giriniz...'" />
					<input type="submit" class="submit" value="" />
				</form>

