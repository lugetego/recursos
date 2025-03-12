<?php

namespace App\Entity;

use App\Repository\SolicitudRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=SolicitudRepository::class)
 */
class Solicitud
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Gedmo\Slug(fields={"solicitante","fecha"}, updatable=false)
     */
    private $slug;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $solicitante;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $acta;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}.")
     */

    private $importe;

    /**
     * @ORM\Column(type="date")
     */
    private $inicio;

    /**
     * @ORM\Column(type="date")
     */
    private $fin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $responsable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $institucion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lugar;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $motivo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipoActividad;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $tituloActividad;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}.")
     */
    private $tcCCM;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}.")
     */
    private $taCCM;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}.")
     */
    private $taProyecto;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type(
     *     type="float",
     *     message="The value {{ value }} is not a valid {{ type }}.")
     */
    private $tcProyecto;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Expression(
     *     "not (this.getFuente() in ['Conacyt', 'PAPIME', 'PAPIIT', ] and this.getProyecto()==null)",
     *     message="Valor requerido"
     * )
     * )
     */
    private $proyecto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fuente;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }


    public function getSolicitante(): ?string
    {
        return $this->solicitante;
    }

    public function setSolicitante(string $solicitante): self
    {
        $this->solicitante = $solicitante;

        return $this;
    }

    public function getActa(): ?string
    {
        return $this->acta;
    }

    public function setActa(string $acta): self
    {
        $this->acta = $acta;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * @param mixed $importe
     */
    public function setImporte($importe): void
    {
        $this->importe = $importe;
    }

    public function getInicio(): ?\DateTimeInterface
    {
        return $this->inicio;
    }

    public function setInicio(\DateTimeInterface $inicio): self
    {
        $this->inicio = $inicio;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(string $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getLugar(): ?string
    {
        return $this->lugar;
    }

    public function setLugar(string $lugar): self
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * @param mixed $motivo
     */
    public function setMotivo($motivo): void
    {
        $this->motivo = $motivo;
    }

    /**
     * @return mixed
     */
    public function getTcCCM()
    {
        return $this->tcCCM;
    }

    /**
     * @param mixed $tcCCM
     */
    public function setTcCCM($tcCCM): void
    {
        $this->tcCCM = $tcCCM;
    }

    /**
     * @return mixed
     */
    public function getTaCCM()
    {
        return $this->taCCM;
    }

    /**
     * @param mixed $taCCM
     */
    public function setTaCCM($taCCM): void
    {
        $this->taCCM = $taCCM;
    }



    /**
     * @return mixed
     */
    public function getTcProyecto()
    {
        return $this->tcProyecto;
    }

    /**
     * @param mixed $tcProyecto
     */
    public function setTcProyecto($tcProyecto): void
    {
        $this->tcProyecto = $tcProyecto;
    }


    public function getProyecto(): ?string
    {
        return $this->proyecto;
    }

    public function setProyecto(?string $proyecto): self
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    public function getFuente(): ?string
    {
        return $this->fuente;
    }

    public function setFuente(string $fuente): self
    {
        $this->fuente = $fuente;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }

    /**
     * @param mixed $institucion
     */
    public function setInstitucion($institucion): void
    {
        $this->institucion = $institucion;
    }

    /**
     * @return mixed
     */
    public function getTipoActividad()
    {
        return $this->tipoActividad;
    }

    /**
     * @param mixed $tipoActividad
     */
    public function setTipoActividad($tipoActividad): void
    {
        $this->tipoActividad = $tipoActividad;
    }

    /**
     * @return mixed
     */
    public function getTituloActividad()
    {
        return $this->tituloActividad;
    }

    /**
     * @param mixed $tituloActividad
     */
    public function setTituloActividad($tituloActividad): void
    {
        $this->tituloActividad = $tituloActividad;
    }

    /**
     * @return mixed
     */
    public function getTaProyecto()
    {
        return $this->taProyecto;
    }

    /**
     * @param mixed $taProyecto
     */
    public function setTaProyecto($taProyecto): void
    {
        $this->taProyecto = $taProyecto;
    }







}
