# -*- coding: utf-8 -*-

import sys, os
from sphinx.highlighting import lexers
from pygments.lexers.web import PhpLexer

lexers['php'] = PhpLexer(startinline=True)
extensions = []

source_suffix = '.rst'
source_encoding = 'utf-8'
master_doc = 'index'

language = 'php'
highlight_language = 'php'

exclude_trees = []
exclude_patterns = []

html_theme_path = ["_themes"]
html_theme = 'twig-bridge'
