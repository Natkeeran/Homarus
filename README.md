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
