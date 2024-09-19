<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>

    <xsl:template match="/">
        <h2>Monthly Product Report</h2>

        <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price (RM)</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Total Sold</th>
                    <th>Recommended Restock Quantity</th>
                </tr>
            </thead>
            <tbody>
                <xsl:for-each select="report/products/product">
                    <tr>
                        <td><xsl:value-of select="id"/></td>
                        <td><xsl:value-of select="name"/></td>
                        <td><xsl:value-of select="type"/></td>
                        <td><xsl:value-of select="price"/></td>
                        <td><xsl:value-of select="stock"/></td>
                        <td><xsl:value-of select="status"/></td>
                        <td><xsl:value-of select="total_sold"/></td>
                        <td><xsl:value-of select="restock_recommendation"/></td>
                    </tr>
                </xsl:for-each>
            </tbody>
        </table>
        <h4>Total Inventory Value: RM <xsl:value-of select="/report/total_value"/></h4>
        <h4>Inventory Turnover Rate: <xsl:value-of select="/report/inventory_turnover_rate"/></h4>
    </xsl:template>
</xsl:stylesheet>
