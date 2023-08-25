<?php

namespace App\Entity;

use App\Repository\BatchRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BatchRepository::class)
 */
class Batch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $batch;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroBloco;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stringEntrada;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chaveEncontrada;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hashGerado;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroTentativas;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBatch(): ?DateTime
    {
        return $this->batch;
    }

    public function getNumeroBloco(): ?int
    {
        return $this->numeroBloco;
    }

    public function setNumeroBloco(int $numeroBloco): self
    {
        $this->numeroBloco = $numeroBloco;

        return $this;
    }

    public function getStringEntrada(): ?string
    {
        return $this->stringEntrada;
    }

    public function setStringEntrada(string $stringEntrada): self
    {
        $this->stringEntrada = $stringEntrada;

        return $this;
    }

    public function getChaveEncontrada(): ?string
    {
        return $this->chaveEncontrada;
    }

    public function setBatch(DateTime $batch): self
    {
        $this->batch = $batch;
        return $this;
    }

    public function setChaveEncontrada(string $chaveEncontrada): self
    {
        $this->chaveEncontrada = $chaveEncontrada;

        return $this;
    }

    public function getHashGerado(): ?string
    {
        return $this->hashGerado;
    }

    public function setHashGerado(string $hashGerado): self
    {
        $this->hashGerado = $hashGerado;

        return $this;
    }

    public function getNumeroTentativas(): ?int
    {
        return $this->numeroTentativas;
    }

    public function setNumeroTentativas(int $numeroTentativas): self
    {
        $this->numeroTentativas = $numeroTentativas;

        return $this;
    }
}
