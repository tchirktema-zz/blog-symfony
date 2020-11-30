<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class RegistrationTest extends WebTestCase
{
    /**
     * @dataProvider provideValidCredentials
     * @param string $email
     * @param string $password
     * @param string $nickname
     */
    public function testIfLoginIsSuccessful(string $email, string $password, string $nickname) : void
    {
        $client = static::createClient();

        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate('registration')
        );

        $form = $crawler->filter("form[name=registration]")->form([
            "registration[email]" => $email,
            "registration[plainPassword]" => $password,
            "registration[nickname]" => $nickname
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertRouteSame('index');
    }

    public function provideValidCredentials(): iterable
    {
        yield ["josue@email.com","password","josue"];
    }
}
