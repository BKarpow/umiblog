<?php


namespace App\Http\Responses;


class ApiResponse
{
    public bool $ok;
    public int $code;
    public bool $error;
    public string $message;
    public array $data;
    public int $length;
    public bool $emptySet;

    public function __construct(bool $ok = false, string $message = '', array $data = [])
    {
        $this->setOk($ok);
        $this->setMessage($message);
        $this->setError(false);
        $this->setCode(200);
        $this->setLength(0);
        $this->setData($data);
        $this->setEmptySet(false);
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->ok;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->setLength(count($data));
        if ($this->getLength() === 0) {
            $this->setEmptySet(true);
        }
        $this->data = $data;
    }

    /**
     * @param bool $error
     */
    public function setError(bool $error): void
    {
        $this->error = $error;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param bool $ok
     */
    public function setOk(bool $ok): void
    {
        $this->ok = $ok;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length): void
    {
        $length = abs( $length );
        $this->length = $length;
    }

    /**
     * @return bool
     */
    public function isEmptySet(): bool
    {
        return $this->emptySet;
    }

    /**
     * @param bool $emptySet
     */
    public function setEmptySet(bool $emptySet): void
    {
        $this->emptySet = $emptySet;
    }
}
