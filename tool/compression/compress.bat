cd C:\computer\workspace\ci42\assets\js\cache
DEL /F/Q/S *.* > NUL
cd C:\computer\workspace\ci42\assets\css\cache
DEL /F/Q/S *.* > NUL
php C:\computer\workspace\ci42\tool\compression\compress.php
@pause