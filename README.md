# Homarus

### Apache Config
```
# managed by Ansible

Alias "/homarus" "/var/www/html/Crayfish/Homarus/src"
<Directory "/var/www/html/Crayfish/Homarus/src">
  FallbackResource /homarus/index.php
  Require all granted
  DirectoryIndex index.php
  SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
</Directory>
```

### Testing
```
curl -H "Authorization: Bearer islandora" -H "Accept: video/x-msvideo" -H "Apix-Ldp-Resource:http://localhost:8080/fcrepo/rest/testvideo" http://localhost:8000/homarus/convert --output output.avi
```
