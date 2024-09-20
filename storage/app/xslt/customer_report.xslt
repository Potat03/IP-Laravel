<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" doctype-public="XSLT-compat" indent="yes"/>
    <xsl:param name="sortField" select="'total_spent'" />

    <!-- Add a CSS style block for better styling -->
    <xsl:template match="/">
        <html>
        <head>
            <title>Customer Report</title>
            <style>
                h1, h2 {
                    text-align: center;
                    color: #4CAF50;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                th, td {
                    padding: 10px;
                    border: 1px solid #ddd;
                    text-align: left;
                }
                th {
                    background-color: #4CAF50;
                    color: white;
                    cursor: pointer;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                tr:hover {
                    background-color: #f1f1f1;
                }
                .status-active {
                    background-color: #dff0d8;
                }
                .status-suspended {
                    background-color: #f2dede;
                }
                .summary {
                    font-size: 18px;
                    margin-bottom: 20px;
                }
            </style>
            <script>
                function sortTable(sortField) {
                    window.location.href = '?sortField=' + sortField;
                }
            </script>
        </head>
        <body>
            <div class="summary">
                Total Customers: <xsl:value-of select="count(customers/customer)" /><br/>
                Total Spending: $<xsl:value-of select="sum(customers/customer/total_spent)" />
            </div>

            <h2>Customer Spending Bar Chart</h2>
            <svg width="600" height="400" xmlns="http://www.w3.org/2000/svg">
                <xsl:for-each select="customers/customer">
                    <xsl:variable name="barHeight" select="total_spent div 10"/>
                    <rect x="{position() * 40}" y="{400 - $barHeight}" width="30" height="{$barHeight}" style="fill:blue;">
                        <title>
                            <xsl:value-of select="username"/>: $<xsl:value-of select="total_spent"/>
                        </title>
                    </rect>
                </xsl:for-each>
            </svg>

            <table>
                <tr>
                    <th onclick="sortTable('id')">ID</th>
                    <th onclick="sortTable('username')">Username</th>
                    <th onclick="sortTable('email')">Email</th>
                    <th onclick="sortTable('tier')">Tier</th>
                    <th onclick="sortTable('status')">Status</th>
                    <th onclick="sortTable('total_spent')">Total Spent ($)</th>
                </tr>
                
                <xsl:for-each select="customers/customer">
                    <xsl:sort select="*[name()=$sortField]" data-type="number"/>
                    <tr>
                        <td><xsl:value-of select="id"/></td>
                        <td><xsl:value-of select="username"/></td>
                        <td><xsl:value-of select="email"/></td>
                        <td><xsl:value-of select="tier"/></td>
                        <td><xsl:value-of select="status"/></td>
                        <td><xsl:value-of select="format-number(total_spent, '#,##0.00')"/></td>
                    </tr>
                </xsl:for-each>
            </table>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
