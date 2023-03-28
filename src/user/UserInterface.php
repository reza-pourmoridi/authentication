<?php

interface UserInterface
{
    public function getUsername(): string;

    public function getPassword(): string;


    public function getRoles(): array;

    public function eraseCredentials(): void;
}