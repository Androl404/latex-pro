keywords = ['addcontentsline', 'addtocontents', 'addtocounter', 'address', 'addtolength', 'addvspace', 'alph', 'appendix', 'arabic', 'author', 'backslash', 'baselineskip', 'baselinestretch', 'bf', 'bibitem', 'bigskipamount', 'bigskip', 'boldmath', 'boldsymbol', 'cal', 'caption', 'cdots', 'centering', 'chapter', 'circle', 'cite', 'cleardoublepage', 'clearpage', 'cline', 'closing', 'color', 'copyright', 'dashbox', 'date', 'ddots', 'documentclass', 'dotfill', 'em', 'emph', 'ensuremath', 'epigraph', 'euro', 'fbox', 'flushbottom', 'fnsymbol', 'footnote', 'footnotemark', 'footnotesize', 'footnotetext', 'frac', 'frame', 'framebox', 'frenchspacing', 'hfill', 'hline', 'href', 'hrulefill', 'hspace', 'huge', 'Huge', 'hyphenation', 'include', 'includegraphics', 'includeonly', 'indent', 'input', 'it', 'item', 'kill', 'label', 'large', 'Large', 'LARGE', 'LaTeX', 'LaTeXe', 'ldots', 'left', 'lefteqn', 'line', 'linebreak', 'linethickness', 'linewidth', 'listoffigures', 'listoftables', 'location', 'makebox', 'maketitle', 'markboth', 'mathcal', 'mathop', 'mbox', 'medskip', 'multicolumn', 'multiput', 'newcommand', 'newcolumntype', 'newcounter', 'newenvironment', 'newfont', 'newlength', 'newline', 'newpage', 'newsavebox', 'newtheorem', 'nocite', 'noindent', 'nolinebreak', 'nonfrenchspacing', 'normalsize', 'nopagebreak', 'not', 'onecolumn', 'opening', 'oval', 'overbrace', 'overline', 'pagebreak', 'pagenumbering', 'pageref', 'pagestyle', 'par', 'paragraph', 'parbox', 'parindent', 'parskip', 'part', 'protect', 'providecommand', 'put', 'raggedbottom', 'raggedleft', 'raggedright', 'raisebox', 'ref', 'renewcommand', 'right', 'rm', 'roman', 'rule', 'savebox', 'sbox', 'sc', 'scriptsize', 'section', 'setcounter', 'setlength', 'settowidth', 'sf', 'shortstack', 'signature', 'sl', 'slash', 'small', 'smallskip', 'sout', 'space', 'sqrt', 'stackrel', 'stepcounter', 'subparagraph', 'subsection', 'subsubsection', 'tableofcontents', 'telephone', 'TeX', 'textbf', 'textcolor', 'textit', 'textmd', 'textnormal', 'textrm', 'textsc', 'textsf', 'textsl', 'texttt', 'textup', 'textwidth', 'textheight', 'thanks', 'thispagestyle', 'tiny', 'title', 'today', 'tt', 'twocolumn', 'typeout', 'typein', 'uline', 'underbrace', 'underline', 'unitlength', 'usebox', 'usecounter', 'uwave', 'value', 'vbox', 'vcenter', 'vdots', 'vector', 'verb', 'vfill', 'vline', 'vphantom', 'vspace', 'RequirePackage', 'NeedsTeXFormat', 'usepackage', 'input', 'include', 'documentclass', 'documentstyle', 'def', 'edef', 'defcommand', 'if', 'ifdim', 'ifnum', 'ifx', 'fi', 'else', 'begingroup', 'endgroup', 'definecolor', 'textcolor', 'color', 'eifstrequal', 'eeifstrequal',];

require(['vs/editor/editor.main'], function() {
    monaco.languages.register({ id: 'latex' });

    monaco.languages.setMonarchTokensProvider('latex', {
        'defaultToken': '',
        'tokenPostfix': '.latex',
        'displayName': 'LaTeX',
        'name': 'latex',
        'mimeTypes': [
            'text/latex',
            'text/tex',
        ],
        'fileExtensions': [
            'tex',
            'sty',
            'cls',
        ],
        'lineComment': '% ',
        'builtin': keywords,
        'tokenizer': {
            'root': [
                [
                    '(\\\\begin)(\\s*)(\\{)([\\w\\-\\*\\@]+)(\\})',
                    [
                        'keyword.predefined',
                        'white',
                        '@brackets',
                        {
                            'token': 'tag.env-$4',
                            'bracket': '@open',
                        },
                        '@brackets',
                    ],
                ],
                [
                    '(\\\\end)(\\s*)(\\{)([\\w\\-\\*\\@]+)(\\})',
                    [
                        'keyword.predefined',
                        'white',
                        '@brackets',
                        {
                            'token': 'tag.env-$4',
                            'bracket': '@close',
                        },
                        '@brackets',
                    ],
                ],
                [
                    '\\\\[^a-zA-Z@]',
                    'keyword',
                ],
                [
                    '\\@[a-zA-Z@]+',
                    'keyword.at',
                ],
                [
                    '\\\\([a-zA-Z@]+)',
                    {
                        'cases': {
                            '$1@builtin': 'keyword.predefined',
                            '@default': 'keyword',
                        },
                    },
                ],
                {
                    'include': '@whitespace',
                },
                [
                    '[{}()\\[\\]]',
                    '@brackets',
                ],
                [
                    '#+\\d',
                    'number.arg',
                ],
                [
                    '\\-?(?:\\d+(?:\\.\\d+)?|\\.\\d+)\\s*(?:em|ex|pt|pc|sp|cm|mm|in)',
                    'number.len',
                ],
            ],
            'whitespace': [
                [
                    '[ \\t\\r\\n]+',
                    'white',
                ],
                [
                    '%.*$',
                    'comment',
                ],
            ],
        },
    });

    const config = {
        surroundingPairs: [
            { open: '{', close: '}' },
            { open: '[', close: ']' },
            { open: '(', close: ')' },
            { open: '<', close: '>' },
            { open: "'", close: "'" },
            { open: '"', close: '"' },
        ],
        autoClosingPairs: [
            { open: '{', close: '}' },
            { open: '[', close: ']' },
            { open: '(', close: ')' },
            { open: "'", close: "'", notIn: ['string', 'comment'] },
            { open: '"', close: '"', notIn: ['string', 'comment'] },
        ],
    };
    monaco.languages.setLanguageConfiguration('latex', config);

    monaco.languages.registerCompletionItemProvider("latex", {
        provideCompletionItems: (model, position) => {
            const suggestions = [
                ...keywords.map(k => {
                    return {
                        label: k,
                        kind: monaco.languages.CompletionItemKind.Keyword,
                        insertText: k,
                    };
                })
            ];
            return { suggestions: suggestions };
        }
    });

});

