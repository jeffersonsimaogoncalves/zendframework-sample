<?php
/**
 * Created by PhpStorm.
 * User: Jefferson Simão Gonçalves
 * Email: gerson.simao.92@gmail.com
 * Date: 20/06/2018
 * Time: 19:27
 */

namespace Blog\Model;

use DomainException;

class PostRepository implements PostRepositoryInterface
{
    private $data = [
        1 => [
            'id' => 1,
            'title' => 'Hello World #1',
            'text' => 'This is our first blog post!',
        ],
        2 => [
            'id' => 2,
            'title' => 'Hello World #2',
            'text' => 'This is our second blog post!',
        ],
        3 => [
            'id' => 3,
            'title' => 'Hello World #3',
            'text' => 'This is our third blog post!',
        ],
        4 => [
            'id' => 4,
            'title' => 'Hello World #4',
            'text' => 'This is our fourth blog post!',
        ],
        5 => [
            'id' => 5,
            'title' => 'Hello World #5',
            'text' => 'This is our fifth blog post!',
        ],
    ];

    public function findAllPosts()
    {
        return array_map(function ($post) {
            return new Post(
                $post['title'],
                $post['text'],
                $post['id']
            );
        }, $this->data);
    }

    public function findPost($id)
    {
        if (!isset($this->data[$id])) {
            throw new DomainException(sprintf('Post by id "%s" not found', $id));
        }

        return new Post(
            $this->data[$id]['title'],
            $this->data[$id]['text'],
            $this->data[$id]['id']
        );
    }

}