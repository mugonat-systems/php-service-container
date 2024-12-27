# Basic Service Container

Resolve dependencies like a pro

```php
use Mugonat\Container\Container;
use Mugonat\Container\Example\Models\Mail;
use Mugonat\Container\Example\Models\MailSender;
use Mugonat\Container\Example\Models\User;
use function Mugonat\Container\dependency;

require __DIR__ . '/../vendor/autoload.php';

// Old way, DON'T DO THIS
$instance = new User(new Mail(new MailSender()));
$instance->sendMail("alex (Using old instantiation)");

// New ways, pick one
// 1.
$container = new Container;
$instance = $container->get(User::class);
$instance->sendMail("alex (Using own container instance)");

// 2.
$instance = Container::instance()->get(User::class);
$instance->sendMail("alex (Using default container)");

// 3.
$instance = dependency(User::class);
$instance->sendMail("alex (Using dependency helper)");
```

You can find the full example [here](./example/index.php)