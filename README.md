## Belajar Laravel REST API - Dasar / Beginner

## How to run

-   clone or unzip downloaded project
-   set up the env
-   create the database
-   do migration
-   Insert data user and any other necessary data for starter

## What I discover

-   Kalau di routing nya kita pakai Route::resource, kita bisa pake default method sesuai yg dibikinin dan ini berpengaruh ke parameter function nya. Walau aku pakai nama function yg sama tapi bikin routing yg beda, parameter dan isi jeroan default yg dibelakang gk kepanggil.
-   Bikin Register user
-   Bikin class helper, aku pake cara yg assign pake provider [Tutorial dari sini ada 3 cara](https://medium.com/@razamoh/create-own-custom-helper-functions-classes-in-laravel-e8d2f50ff38), ini [Pembahasan stackoverflow nya](https://stackoverflow.com/questions/28290332/how-to-create-custom-helper-functions-in-laravel).
-   Bikin Update image juga
-   Terjadi known error saat ingin menggunakan form-data untuk update yaitu gk ada request yg dikirim tidak seperti saat mengirimkan berupa json. Walau ini Rest API tapi kyk web app nya laravel juga. Jadi method di postman kita POST tapi kita kasih parameter `_method=PATCH` jadi kyk kasih `@method('PATCH')`. Dengan ini baru bisa pakai form-data.

## Content

Aku bikin juga beginiannya biar gk ke bingung atau ke campur jika nanti adding pembahasan baru dari repo ini. Karena kemungkinan playlist dari tips & trick akan masuk kesini juga.

### Rest API

-   Disini isinya dasar / basic cara buat API dengan laravel. Tutorial nya ngambil dari channel cara fajar [playlist laravel api](https://www.youtube.com/playlist?list=PLnrs9DcLyeJSfhHHbze8NfaHFh55HNBSh). Discovery selama playlist ini berjalan dah ku tulis [di atas](#what-i-discover)
