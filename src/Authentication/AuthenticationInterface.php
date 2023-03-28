<?php

interface AuthenticationInterface
{
    public function login(string $username, string $password): bool;
    public function logout(): void;
    public function isLoggedIn(): bool;
    public function getCurrentUser(): ?User;
    public function register(array $userData): ?User;
    public function userExists(string $username): bool;
}