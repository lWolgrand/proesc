SELECT
    clientes.nome,
    clientes.numero_telefone,
    COUNT(parcelas.id) AS quantidade_parcelas_nao_pagas,
    SUM(parcelas.valor) AS total_nao_pago
FROM
    clientes
        LEFT JOIN
    pagamentos ON clientes.id = pagamentos.cliente_id
        LEFT JOIN
    parcelas ON pagamentos.id = parcelas.pagamento_id
WHERE
    parcelas.status = 'pendente'
GROUP BY
    clientes.id, clientes.nome, clientes.numero_telefone