<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2015, Hoa community. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Hoa\Console\Readline\Autocompleter;

/**
 * Class \Hoa\Console\Readline\Autocompleter\Word.
 *
 * The simplest auto-completer: complete a word.
 *
 * @copyright  Copyright © 2007-2015 Hoa community
 * @license    New BSD License
 */
class Word implements Autocompleter
{
    /**
     * List of words.
     *
     * @var array
     */
    protected $_words = null;



    /**
     * Constructor.
     *
     * @param   array  $words    Words.
     * @return  void
     */
    public function __construct(Array $words)
    {
        $this->setWords($words);

        return;
    }

    /**
     * Complete a word.
     * Returns null for no word, a full-word or an array of full-words.
     *
     * @param   string  &$prefix    Prefix to autocomplete.
     * @return  mixed
     */
    public function complete(&$prefix)
    {
        $out    = [];
        $length = mb_strlen($prefix);

        foreach ($this->getWords() as $word) {
            if (mb_substr($word, 0, $length) === $prefix) {
                $out[] = $word;
            }
        }

        if (empty($out)) {
            return null;
        }

        if (1 === count($out)) {
            return $out[0];
        }

        return $out;
    }

    /**
     * Get definition of a word.
     *
     * @return  string
     */
    public function getWordDefinition()
    {
        return '\b\w+\b';
    }

    /**
     * Set list of words.
     *
     * @param   array  $words    Words.
     * @return  array
     */
    public function setWords(Array $words)
    {
        $old          = $this->_words;
        $this->_words = $words;

        return $old;
    }

    /**
     * Get list of words.
     *
     * @return  array
     */
    public function getWords()
    {
        return $this->_words;
    }
}