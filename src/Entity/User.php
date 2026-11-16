<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuario de IssueFlow.
 *
 * Permite gestionar los datos personales, la autenticación
 * y los permisos de cada usuario.
 */
#[ORM\Entity]
#[ORM\Table(name: 'users')]
final class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * Identificador técnico de la base de datos.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    private ?int $id = null;

    /**
     * Hash de la contraseña.
     * Nunca almacenamos la contraseña en texto plano.
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    /**
     * Roles almacenados en formato JSON.
     */
    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $roles = [];

    public function __construct(
        #[ORM\Column(length: 120)]
        private string $name,

        #[ORM\Column(length: 180, unique: true)]
        private string $email,
    ) {
        // Normalizamos el nombre y el correo electrónico.
        $normalizedName = trim($name);
        $normalizedEmail = strtolower(trim($email));

        if ($normalizedName === '') {
            throw new InvalidArgumentException(
                'El nombre del usuario no puede estar vacío'
            );
        }

        if (filter_var($normalizedEmail, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException(
                'El email no es válido'
            );
        }

        $this->name = $normalizedName;
        $this->email = $normalizedEmail;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Devuelve el identificador utilizado para iniciar sesión.
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * Devuelve los roles del usuario.
     * Todos los usuarios tienen ROLE_USER como mínimo.
     */
    public function getRoles(): array
    {
        $roles = $this->roles ?? [];

        $roles[] = 'ROLE_USER';

        return array_values(array_unique($roles));
    }

    /**
     * Permite modificar los roles del usuario.
     */
    public function setRoles(array $roles): void
    {
        $this->roles = array_values(array_unique($roles));
    }

    /**
     * Devuelve el hash de la contraseña.
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Guarda el hash de la contraseña.
     */
    public function setPassword(string $hash): void
    {
        $this->password = $hash;
    }
}
