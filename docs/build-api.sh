#!/bin/bash
apigen -s /var/www/projects/benrowe.info/protected/controllers/ -s /var/www/projects/benrowe.info/protected/models/ -s /var/www/projects/benrowe.info/protected/sfd/ -s /var/www/projects/benrowe.info/protected/components/ -s /var/www/projects/benrowe.info/protected/modules/ -s /var/www/projects/benrowe.info/protected/extensions/ -d /var/www/projects/benrowe.info/docs/api/  --main CMS --title CMS --autocomplete classes,constants,methods,functions --access-levels public,protected,private --todo yes

