DEVELOP MASTER TABLE ADMINISTRATION : Create Fixture (with Faker)
-----------------------------------------------------------------

- Create fixture template & data directory

```sh
$ mkdir --parents vendor/adipriyantobpn/klog-country/tests/codeception/common/templates/fixtures
$ mkdir --parents vendor/adipriyantobpn/klog-country/tests/codeception/common/fixtures/data
```

- Create fixture template files

in ` vendor/adipriyantobpn/klog-country/tests/codeception/common/templates/fixtures/country.php `

```php
<?php/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'name' => $faker->country,
    'status' => $faker->boolean(),
    'created_at' => $faker->date('Y-m-d H:i:s', 'now'),
    'updated_at' => $faker->date('Y-m-d H:i:s', 'now'),
    'created_by' => $faker->numberBetween(1, 10),
    'updated_by' => $faker->numberBetween(1, 10),
];
```

- Generate fixture data

```sh
//-- generate one-by-one
$ tests/codeception/bin/yii fixture/generate --templatePath=@vendor/adipriyantobpn/klog-country/tests/codeception/common/templates/fixtures --fixtureDataPath=@vendor/adipriyantobpn/klog-country/tests/codeception/common/fixtures/data --count=10 country
//-- or generate all
$ tests/codeception/bin/yii fixture/generate-all --templatePath=@vendor/adipriyantobpn/klog-country/tests/codeception/common/templates/fixtures --fixtureDataPath=@vendor/adipriyantobpn/klog-country/tests/codeception/common/fixtures/data --count=10
```

- Create fixture class

*NOTE : it should be located in ` vendor/adipriyantobpn/klog-country/tests/codeception/common/fixtures ` directory*

```php
<?php
namespace adipriyantobpn\klog\country\tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

/**
 * Country fixture
 */
class CountryFixture extends ActiveFixture
{
    public $modelClass = 'adipriyantobpn\klog\country\models\tables\Country';
}
```

- Load fixtures data into database

*NOTE : fixture name must resemblance with fixture class name, and must be started with UPPERCASE letter*

```sh
$ tests/codeception/bin/yii fixture/load --namespace='adipriyantobpn\klog\country\tests\codeception\common\fixtures' Country
```