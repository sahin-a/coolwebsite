<?php


class Header
{
    private string $alg;
    private string $typ;

    private function __construct()
    {
    }

    public static function createInstance($alg, $typ) : self
    {
        $header = new self;
        $header->alg = $alg;
        $header->typ = $typ;

        return $header;
    }

    public static function createDefaultHeader() : Header
    {
        $header = new self;
        $header->alg = JWTAlgs::HS256;
        $header->typ = JWTType::JWT;

        return $header;
    }

    /**
     * @return string
     */
    public
    function getAlg(): string
    {
        return $this->alg;
    }

    /**
     * @param string $alg
     */
    public
    function setAlg(string $alg): void
    {
        $this->alg = $alg;
    }

    /**
     * @return string
     */
    public
    function getTyp(): string
    {
        return $this->typ;
    }

    /**
     * @param string $typ
     */
    public
    function setTyp(string $typ): void
    {
        $this->typ = $typ;
    }
}