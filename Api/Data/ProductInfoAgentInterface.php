<?php

namespace Gundo\ProductInfoAgent\Api\Data;

interface ProductInfoAgentInterface
{
    /**
     * String constants for property names
     */
    public const ID = "chat_id";
    public const MESSAGE = "message";
    public const DATA = "data";
    public const UPDATED_AT = "updated_at";
    public const CREATED_AT = "created_at";
    public const USER_ID = "user_id";
    public const MODEL = "model";

    /**
     * Getter for Id.
     *
     * @return int|null
     */
    public function getChatId(): ?int;

    /**
     * Setter for Id.
     *
     * @param int $chatId
     * @return $this
     */
    public function setChatId(?int $chatId);

    /**
     * Getter for Message.
     *
     * @return string|null
     */
    public function getMessage(): ?string;

    /**
     * Setter for Message.
     *
     * @param string|null $message
     * @return $this
     */
    public function setMessage(?string $message): self;

    /**
     * Getter for UpdatedAt.
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Setter for UpdatedAt.
     *
     * @param string|null $updatedAt
     * @return $this
     */
    public function setUpdatedAt(?string $updatedAt): self;

    /**
     * Getter for CreatedAt.
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Setter for CreatedAt.
     *
     * @param string|null $createdAt
     * @return $this
     */
    public function setCreatedAt(?string $createdAt): self;

    /**
     * Getter for UserId.
     *
     * @return int|null
     */
    public function getUserId(): ?int;

    /**
     * Setter for UserId.
     *
     * @param int|null $userId
     * @return $this
     */
    public function setUserId(?int $userId): self;

    /**
     * Getter for Model.
     *
     * @return string|null
     */
    public function getModel(): ?string;

    /**
     * Setter for Model.
     *
     * @param string|null $model
     * @return $this
     */
    public function setModel(?string $model): self;
}
