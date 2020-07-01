<?php
declare(strict_types=1);

namespace hiqdev\yii2\mfa\base;

use Yii;
use yii\base\BaseObject;

class RecoveryCodeCollection extends BaseObject
{
    protected $codes = [];

    protected $count = 10;

    protected $blocks = 4;

    protected $blockLength = 3;

    protected $blockSeparator = '-';

    public function getCodes(): array
    {
        return $this->codes;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setBlocks(int $blocks): self
    {
        $this->blocks = $blocks;

        return $this;
    }

    public function getBlocks(): int
    {
        return $this->blocks;
    }

    public function setBlockLength(int $length): self
    {
        $this->blockLength = $length;

        return $this;
    }

    public function getBlockLength(): int
    {
        return $this->blockLength;
    }

    public function setBlockSeparator(string $separator): self
    {
        $this->blockSeparator = $separator;

        return $this;
    }

    public function getBlockSeparator(): string
    {
        return $this->blockSeparator;
    }

    public function generate(): self
    {
        $this->reset();
        foreach (range(1, $this->getCount()) as $counter) {
            $this->codes[] = $this->generateCode();
        }

        return $this;
    }

    public function save(): bool
    {
        $userId = Yii::$app->user->identity->id;
        Recovery::deleteAll(['user_id' => $userId]);

        $errors = [];
        foreach ($this->getCodes() as $code){
            $recovery = new Recovery();
            if (!$recovery->setUser($userId)->setCode($code)->save()){
                $errors[] = $recovery->getErrors();
            }
        }

        return empty($errors);
    }

    private function generateCode(): string
    {
        $codeBlocks = [];
        foreach (range(1, $this->getBlocks()) as $counter) {
            $codeBlocks[] = $this->generateBlock();
        }

        return implode($this->getBlockSeparator(), $codeBlocks);
    }

    private function generateBlock(): string
    {
        return bin2hex(random_bytes($this->getBlockLength()));
    }

    private function reset(): self
    {
        $this->codes = [];

        return $this;
    }

}