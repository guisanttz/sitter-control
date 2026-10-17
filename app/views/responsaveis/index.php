<div class="list-head">
    <div class="search-inline"><svg>
            <use href="#i-search" />
        </svg><input placeholder="Buscar responsável..."></div>
    <div class="head-actions">
        <button class="btn btn-primary" onclick="openModal('responsavel')"><svg>
                <use href="#i-plus" />
            </svg>Novo responsável</button>
    </div>
</div>
<table class="data-table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Contato</th>
            <th>Criança(s)</th>
            <th>Parentesco</th>
            <th>Principal</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Fernanda Almeida</td>
            <td>(18) 99123-4567</td>
            <td>
                <div class="tags-inline"><span class="tag">Sofia</span></div>
            </td>
            <td>Mãe</td>
            <td class="star-yes"><svg>
                    <use href="#i-star" />
                </svg></td>
            <td>
                <div class="row-actions"><button onclick="openModal('responsavel')"><svg>
                            <use href="#i-pencil" />
                        </svg></button><button><svg>
                            <use href="#i-trash" />
                        </svg></button></div>
            </td>
        </tr>
        <tr>
            <td>Rafael Almeida</td>
            <td>(18) 99876-1234</td>
            <td>
                <div class="tags-inline"><span class="tag">Sofia</span></div>
            </td>
            <td>Pai</td>
            <td class="star-no"><svg>
                    <use href="#i-star" />
                </svg></td>
            <td>
                <div class="row-actions"><button onclick="openModal('responsavel')"><svg>
                            <use href="#i-pencil" />
                        </svg></button><button><svg>
                            <use href="#i-trash" />
                        </svg></button></div>
            </td>
        </tr>
    </tbody>
</table>