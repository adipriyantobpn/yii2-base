DEVELOP : Generate Extension
----------------------------

- Generate Extension (with **Yii2 Gii**)

```sh
- Vendor Name : adipriyantobpn 
- Package Name : klog-country 
- Namespace : adipriyantobpn\klog\country\ 
- Type : yii2-extension 
- Keywords : yii2,extension,klog,country 
- License : MIT 
- Title : KLOG Country Manager 
- Description : Country Manager for KLOG WebApp (based on Yii2 Extension) 
- Author Name : Adi Priyanto 
- Author Email : MIT 
- Output Path : @app/runtime/tmp-extensions
- Code Template : default
```

- Track it with **Git**

```sh
$ git init
$ git add .
$ git commit -m "Initial installation : adipriyantobpn/klog-country"
```

*initialize ` git flow ` here ! (can use **SmartGit** or **Sourcetree**)*

- Upload it into **Private VCS Server** (BitBucket)

```sh
$ git remote add origin https://github.com/adipriyantobpn/klog-country.git
$ git push -u origin --all
$ git push -u origin --tags
```

- Import it with **Composer**

```js
"repositories":[
    {
        "type": "git",
        "url": "https://github.com/adipriyantobpn/klog-country.git"
    }
],
"require": {
    ...
    "adipriyantobpn/klog-country": "dev-develop"
},
```

*execute ` composer update `*

```sh
$ composer update
```