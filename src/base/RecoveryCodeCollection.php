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

    public function setCount(int $count)
    {
        $this->count = $count;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setBlocks(int $blocks)
    {
        $this->blocks = $blocks;
    }

    public function getBlocks(): int
    {
        return $this->blocks;
    }

    public function setBlockLength(int $length)
    {
        $this->blockLength = $length;
    }

    public function getBlockLength(): int
    {
        return $this->blockLength;
    }

    public function setBlockSeparator(string $separator)
    {
        $this->blockSeparator = $separator;
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
        $this->remove();

        $errors = [];
        foreach ($this->getCodes() as $code){
            $recovery = new Recovery();
            if (!$recovery->setUser($userId)->setCode($code)->save()){
                $errors[] = $recovery->getErrors();
            }
        }

        return empty($errors);
    }

    public function remove(): int {
        $userId = Yii::$app->user->identity->id;

        return Recovery::deleteAll(['user_id' => $userId]);
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